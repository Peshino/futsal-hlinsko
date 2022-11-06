<?php

namespace Database\Seeders;

use App\Team;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\Competitions;


class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedFromOldDb = config('app.seed_from_old_db');

        if ($seedFromOldDb) {
            $seedFromOldDbWithOneArchive = config('app.seed_from_old_db_with_one_archive');

            $data = DB::connection('mysql_old_db')->select('SELECT * FROM `teams`' . ($seedFromOldDbWithOneArchive !== null ? ' WHERE `archive` = ' . $seedFromOldDbWithOneArchive : ''));
            $historyCodes = [];
            $namesShort = [];
            $competitionsRepository = new Competitions;

            foreach ($data as $key => $item) {
                $name = trim($item->name);
                $class = (int) $item->class;
                $archive = (int) $item->archive;

                if ($name === 'DTJ Juventus Hlinsko B') {
                    $name = 'DTJ Juventus Hlinsko';
                }

                $nameShort = strtoupper(mb_substr(str_replace(' ', '', $name), 0, 3));

                if (in_array($nameShort, $namesShort)) {
                    if (array_key_exists($name, $namesShort)) {
                        $nameShort = $namesShort[$name];
                    } else {
                        $pieces = explode(' ', $name);

                        if (isset($pieces[1])) {
                            $namesShort[$name] = $nameShort = strtoupper(mb_substr(str_replace(' ', '', $pieces[0]), 0, 2)) . strtoupper(mb_substr(str_replace(' ', '', $pieces[1]), 0, 1));
                        } else {
                            $namesShort[$name] = $nameShort = strtoupper(mb_substr(str_replace(' ', '', $name), -3));
                        }
                    }
                } else {
                    $namesShort[$name] = $nameShort;
                }

                $team = Team::query()->where('name', $name)->first();

                if ($team !== null) {
                    $historyCodes[$name] = $team->history_code;
                }

                if (array_key_exists($name, $historyCodes)) {
                    $historyCode = $historyCodes[$name];
                } else {
                    $historyCodes[$name] = $historyCode = bin2hex(random_bytes(8));
                }

                $userId = 3;

                if ($archive === 8) {
                    $competitionId = 14;
                } elseif ($archive === 9) {
                    $competitionId = 15;
                } else {
                    $competitions = $competitionsRepository->getCompetitionsBySeason($archive);
                    foreach ($competitions as $competition) {
                        if (((int) $competition->id) % 2 === 0) {
                            $competitionIdEven = $competition->id;
                        } else {
                            $competitionIdOdd = $competition->id;
                        }
                    }

                    if ($class === 1) {
                        $competitionId = $competitionIdOdd;
                    } else {
                        $competitionId = $competitionIdEven;
                    }
                }

                Team::create([
                    'name' => $name,
                    'name_short' => $nameShort,
                    'history_code' => $historyCode,
                    'user_id' => $userId,
                    'competition_id' => $competitionId,
                ]);
            }
        } else {
            $json = File::get('database/data/teams.json');
            $objects = json_decode($json);
            foreach ($objects as $object) {
                Team::create([
                    'name' => $object->name,
                    'name_short' => $object->name_short,
                    'history_code' => bin2hex(random_bytes(8)),
                    'web_presentation' => $object->web_presentation,
                    'primary_color_id' => $object->primary_color_id,
                    'secondary_color_id' => $object->secondary_color_id,
                    'user_id' => $object->user_id,
                    'competition_id' => $object->competition_id,
                ]);
            }
        }
    }
}
