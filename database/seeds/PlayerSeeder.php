<?php

namespace Database\Seeders;

use App\Player;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\Competitions;
use App\Team;

class PlayerSeeder extends Seeder
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

            $data = DB::connection('mysql_old_db')->select('SELECT * FROM `players`' . ($seedFromOldDbWithOneArchive !== null ? ' WHERE `archive` = ' . $seedFromOldDbWithOneArchive : ''));
            $historyCodes = [];
            $competitionsRepository = new Competitions;

            foreach ($data as $key => $item) {
                $class = (int) $item->class;
                $archive = (int) $item->archive;
                $jmeno = trim(str_replace('  ', ' ', $item->jmeno));
                $tym = trim($item->tym);
                $userId = 3;
                $name = explode(' ', $jmeno);
                $firstname = trim($name[1]);
                $lastname = trim($name[0]);

                if (isset($name[2]) && trim($name[2]) !== '') {
                    $lastname = $lastname . ' ' . trim($name[2]);
                }

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

                if ($lastname === 'Sapoušek') {
                    $lastname = 'Sopoušek';
                }

                if ($tym === 'DTJ Juventus Hlinsko B') {
                    $tym = 'DTJ Juventus Hlinsko';
                }

                if (strpos($tym, 'FC Norton Skute') !== false) {
                    $tym = 'FC Norton Skuteč';
                } elseif (strpos($tym, 'Norton Skute') !== false) {
                    $tym = 'Norton Skuteč';
                }

                if (strpos($tym, 'Sokol Holet') !== false) {
                    $tym = 'Sokol Holetín';
                }

                switch ($archive) {
                    case 1:
                        if ($class === 2) {
                            if ($tym === 'Sokol Studnice') {
                                $tym = 'Sokol Studnice B';
                            }

                            if ($tym === 'Benfica Hlinsko') {
                                $tym = 'Benfica Hlinsko B';
                            }
                        }
                        break;

                    case 2:
                        if ($class === 2) {
                            if ($tym === 'Benfica Hlinsko') {
                                $tym = 'Benfica Hlinsko B';
                            }
                        }
                        break;

                    case 3:
                        if ($class === 1) {
                            if ($tym === 'Benfica Hlinsko') {
                                $tym = 'Benfica Hlinsko B';
                            }
                        } else {
                            if ($tym === 'Benfica Hlinsko') {
                                $tym = 'Benfica Hlinsko C';
                            }
                        }
                        break;

                    case 4:
                        if ($class === 1) {
                            if ($tym === 'Benfica Hlinsko') {
                                $tym = 'Benfica Hlinsko B';
                            }
                        } else {
                            if ($tym === 'Benfica Hlinsko') {
                                $tym = 'Benfica Hlinsko C';
                            }

                            if ($tym === 'Hattrick Svratka') {
                                $tym = 'Hattrick Svratka B';
                            }
                        }
                        break;

                    case 5:
                        if ($class === 1) {
                            if ($tym === 'Benfica Hlinsko') {
                                $tym = 'Benfica Hlinsko B';
                            }
                        }
                        break;

                    default:
                        # code...
                        break;
                }

                $jmenoTym = $lastname . ' ' . $firstname . '-' . $tym;

                $teamByName = Team::where('name', $tym)->first();
                $player = Player::query()->where(['firstname' => $firstname, 'lastname' => $lastname, 'team_id' => $teamByName->id])->first();

                if ($player !== null) {
                    $historyCodes[$jmenoTym] = $player->history_code;
                }

                if (array_key_exists($jmenoTym, $historyCodes)) {
                    $historyCode = $historyCodes[$jmenoTym];
                } else {
                    $historyCodes[$jmenoTym] = $historyCode = bin2hex(random_bytes(8));
                }

                $team = Team::where('name', $tym)->where('competition_id', $competitionId)->first();

                if ($team === null) {
                    continue;
                }

                Player::create([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'history_code' => $historyCode,
                    'team_id' => $team->id,
                    'user_id' => $userId,
                    'competition_id' => $competitionId,
                ]);
            }
        } else {
            $json = File::get('database/data/players.json');
            $objects = json_decode($json);
            foreach ($objects as $object) {
                Player::create([
                    'firstname' => $object->firstname,
                    'lastname' => $object->lastname,
                    'history_code' => bin2hex(random_bytes(8)),
                    'jersey_number' => $object->jersey_number,
                    'birthdate' => $object->birthdate,
                    'position' => $object->position,
                    'height' => $object->height,
                    'nationality' => $object->nationality,
                    'team_id' => $object->team_id,
                    'user_id' => $object->user_id,
                    'competition_id' => $object->competition_id,
                ]);
            }
        }
    }
}
