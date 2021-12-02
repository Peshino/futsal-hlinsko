<?php

use App\Card;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\Competitions;
use App\Team;
use App\Game;
use App\Player;

class CardSeeder extends Seeder
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
            $data = DB::connection('mysql_old_db')->select('SELECT `cards`.class, `cards`.archive, `cards`.jmeno, `cards`.tym, `cards`.zlute, `cards`.cervene, `cards`.kolo, `cards`.cislo_zapasu, `results`.tym_domaci, `results`.tym_hoste FROM `cards` INNER JOIN results ON `cards`.class = `results`.class AND `cards`.archive = `results`.archive AND `cards`.kolo = `results`.kolo AND `cards`.cislo_zapasu = `results`.cislo_zapasu AND( `results`.tym_domaci = cards.tym || `results`.tym_hoste = cards.tym )');
            $competitionsRepository = new Competitions;

            foreach ($data as $key => $item) {
                $class = (int) $item->class;
                $archive = (int) $item->archive;
                $jmeno = trim(str_replace('  ', ' ', $item->jmeno));
                $tym = trim($item->tym);
                $yellow = (int) $item->zlute;
                $red = (int) $item->cervene;
                $kolo = (int) $item->kolo;
                $cisloZapasu = (int) $item->cislo_zapasu;
                $tymDomaci = trim($item->tym_domaci);
                $tymHoste = trim($item->tym_hoste);
                $userId = 3;
                $name = explode(' ', $jmeno);
                $firstname = trim($name[1]);
                $lastname = trim($name[0]);

                if ($lastname === 'Sapoušek') {
                    $lastname = 'Sopoušek';
                }

                if ($tymDomaci === 'DTJ Juventus Hlinsko B') {
                    $tymDomaci = 'DTJ Juventus Hlinsko';
                }

                if ($tymHoste === 'DTJ Juventus Hlinsko B') {
                    $tymHoste = 'DTJ Juventus Hlinsko';
                }

                switch ($archive) {
                    case 1:
                        if ($class === 2) {
                            if ($tymDomaci === 'Sokol Studnice') {
                                $tymDomaci = 'Sokol Studnice B';
                            }

                            if ($tymHoste === 'Sokol Studnice') {
                                $tymHoste = 'Sokol Studnice B';
                            }

                            if ($tymDomaci === 'Benfica Hlinsko') {
                                $tymDomaci = 'Benfica Hlinsko B';
                            }

                            if ($tymHoste === 'Benfica Hlinsko') {
                                $tymHoste = 'Benfica Hlinsko B';
                            }
                        }
                        break;

                    case 2:
                        if ($class === 2) {
                            if ($tymDomaci === 'Benfica Hlinsko') {
                                $tymDomaci = 'Benfica Hlinsko B';
                            }

                            if ($tymHoste === 'Benfica Hlinsko') {
                                $tymHoste = 'Benfica Hlinsko B';
                            }
                        }
                        break;

                    case 3:
                        if ($class === 1) {
                            if ($tymDomaci === 'Benfica Hlinsko') {
                                $tymDomaci = 'Benfica Hlinsko B';
                            }

                            if ($tymHoste === 'Benfica Hlinsko') {
                                $tymHoste = 'Benfica Hlinsko B';
                            }
                        } else {
                            if ($tymDomaci === 'Benfica Hlinsko') {
                                $tymDomaci = 'Benfica Hlinsko C';
                            }

                            if ($tymHoste === 'Benfica Hlinsko') {
                                $tymHoste = 'Benfica Hlinsko C';
                            }
                        }
                        break;

                    case 4:
                        if ($class === 1) {
                            if ($tymDomaci === 'Benfica Hlinsko') {
                                $tymDomaci = 'Benfica Hlinsko B';
                            }

                            if ($tymHoste === 'Benfica Hlinsko') {
                                $tymHoste = 'Benfica Hlinsko B';
                            }
                        } else {
                            if ($tymDomaci === 'Benfica Hlinsko') {
                                $tymDomaci = 'Benfica Hlinsko C';
                            }

                            if ($tymHoste === 'Benfica Hlinsko') {
                                $tymHoste = 'Benfica Hlinsko C';
                            }

                            if ($tymDomaci === 'Hattrick Svratka') {
                                $tymDomaci = 'Hattrick Svratka B';
                            }

                            if ($tymHoste === 'Hattrick Svratka') {
                                $tymHoste = 'Hattrick Svratka B';
                            }
                        }
                        break;

                    case 5:
                        if ($class === 1) {
                            if ($tymDomaci === 'Benfica Hlinsko') {
                                $tymDomaci = 'Benfica Hlinsko B';
                            }

                            if ($tymHoste === 'Benfica Hlinsko') {
                                $tymHoste = 'Benfica Hlinsko B';
                            }
                        }
                        break;

                    default:
                        # code...
                        break;
                }

                $competitions = $competitionsRepository->getCompetitionsBySeason($archive);
                $competitionIds = $competitions->pluck('id')->toArray();

                if ($archive === 8) {
                    $competitionId = 14;
                } else {
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

                if ($archive === 1) {
                    if ($kolo >= 1 && $kolo <= 5) {
                        $round = $kolo;
                    }

                    if ($kolo >= 6 && $kolo <= 8) {
                        $round = $kolo - 5;
                    }
                } elseif ($archive === 5) {
                    if ($class === 1) {
                        if ($kolo >= 1 && $kolo <= 5) {
                            $round = $kolo;
                        }

                        if ($kolo >= 6 && $kolo <= 8) {
                            $round = $kolo - 5;
                        }
                    } else {
                        $round = $kolo;
                    }
                } elseif ($archive === 6) {
                    $round = $kolo;
                } elseif ($archive === 7) {
                    if ($kolo >= 1 && $kolo <= 7) {
                        $round = $kolo;
                    }

                    if ($kolo >= 8 && $kolo <= 9) {
                        $round = $kolo - 7;
                    }
                } else {
                    if ($kolo >= 1 && $kolo <= 5) {
                        $round = $kolo;
                    }

                    if ($kolo >= 6 && $kolo <= 8) {
                        $round = $kolo - 5;
                    }
                }

                $homeTeam = Team::where('name', $tymDomaci)->where('competition_id', $competitionId)->first();
                $awayTeam = Team::where('name', $tymHoste)->where('competition_id', $competitionId)->first();

                $game = Game::where('round', $round)->where('home_team_id', $homeTeam->id)->where('away_team_id', $awayTeam->id)->where('competition_id', $competitionId)->first();

                $player = Player::where('firstname', $firstname)->where('lastname', $lastname)->whereIn('team_id', [$homeTeam->id, $awayTeam->id])->where('competition_id', $competitionId)->first();

                if ($player === null) {
                    $teamIds = Team::where('name', 'like', '%' . $tym . '%')->pluck('id')->toArray();
                    array_push($teamIds, $homeTeam->id, $awayTeam->id);

                    $player = Player::where('firstname', $firstname)->where('lastname', $lastname)->whereIn('team_id', $teamIds)->whereIn('competition_id', $competitionIds)->first();
                }

                Card::create([
                    'yellow' => $yellow,
                    'red' => $red,
                    'player_id' => $player->id,
                    'team_id' => $player->team_id,
                    'game_id' => $game->id,
                    'user_id' => $userId,
                    'rule_id' => $game->rule_id,
                    'competition_id' => $competitionId,
                ]);
            }
        } else {
            $json = File::get('database/data/cards.json');
            $objects = json_decode($json);
            foreach ($objects as $object) {
                Card::create([
                    'yellow' => $object->yellow,
                    'red' => $object->red,
                    'player_id' => $object->player_id,
                    'team_id' => $object->team_id,
                    'game_id' => $object->game_id,
                    'user_id' => $object->user_id,
                    'rule_id' => $object->rule_id,
                    'competition_id' => $object->competition_id,
                ]);
            }
        }
    }
}
