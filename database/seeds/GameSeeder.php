<?php

use App\Game;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Repositories\Competitions;
use App\Team;
use App\Rule;

class GameSeeder extends Seeder
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
            $data = DB::connection('mysql_old_db')->select('SELECT * FROM `results` WHERE kolo < 100');
            $competitionsRepository = new Competitions;

            foreach ($data as $key => $item) {
                $class = (int) $item->class;
                $archive = (int) $item->archive;
                $kolo = (int) $item->kolo;
                $datum = trim(str_replace('..', '.', str_replace(':', '.', str_replace('. ', '.', $item->datum))));
                $cisloZapasu = (int) $item->cislo_zapasu;
                $tymDomaci = trim($item->tym_domaci);
                $tymHoste = trim($item->tym_hoste);
                $homeTeamScore = (int) $item->skore_domaci;
                $awayTeamScore = (int) $item->skore_hoste;
                $homeTeamHalftimeScore = (int) $item->skore_domaci_polocas;
                $awayTeamHalftimeScore = (int) $item->skore_hoste_polocas;
                $cast = trim($item->cast);
                $userId = 3;

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

                if ($archive === 8) {
                    $competitionId = 14;
                } else {
                    $competitions = $competitionsRepository->getCompetitionsBySeason($archive);
                    foreach ($competitions as $key => $competition) {
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

                        if ($class === 1) {
                            $rule = Rule::find(1);
                        } else {
                            $rule = Rule::find(4);
                        }
                    }

                    if ($kolo >= 6 && $kolo <= 8) {
                        $round = $kolo - 5;

                        if ($class === 1) {
                            $sestupoveTymy = ['FC Norton Skuteč', 'AC Hlinsko', 'Sokol Studnice', 'Oflenda Hlinsko'];

                            if (in_array($tymDomaci, $sestupoveTymy) || in_array($tymHoste, $sestupoveTymy)) {
                                $rule = Rule::find(3);
                            } else {
                                $rule = Rule::find(2);
                            }
                        } else {
                            $sestupoveTymy = ['Vortap Hlinsko', 'RUM-PRO Hlinsko', 'STS Rotor Hlinsko'];

                            if (in_array($tymDomaci, $sestupoveTymy) || in_array($tymHoste, $sestupoveTymy)) {
                                $rule = Rule::find(6);
                            } else {
                                $rule = Rule::find(5);
                            }
                        }
                    }
                } elseif ($archive === 5) {
                    if ($class === 1) {
                        if ($kolo >= 1 && $kolo <= 5) {
                            $round = $kolo;
                            $rule = Rule::find(25);
                        }

                        if ($kolo >= 6 && $kolo <= 8) {
                            $round = $kolo - 5;

                            if ($cast === 'postup') {
                                $rule = Rule::find(26);
                            }

                            if ($cast === 'sestup') {
                                $rule = Rule::find(27);
                            }
                        }
                    } else {
                        $round = $kolo;
                        $rule = Rule::find(28);
                    }
                } elseif ($archive === 6) {
                    $round = $kolo;

                    if ($class === 1) {
                        $rule = Rule::find(29);
                    } else {
                        $rule = Rule::find(30);
                    }
                } elseif ($archive === 7) {
                    if ($kolo >= 1 && $kolo <= 7) {
                        $round = $kolo;
                        $rule = Rule::find(31);
                    }

                    if ($kolo >= 8 && $kolo <= 9) {
                        $round = $kolo - 7;
                        $rule = Rule::find(32);
                    }
                } else {
                    if ($kolo >= 1 && $kolo <= 5) {
                        $round = $kolo;
                        $rule = Rule::where('priority', 1)->where('competition_id', $competitionId)->first();
                    }

                    if ($kolo >= 6 && $kolo <= 8) {
                        $round = $kolo - 5;

                        if ($cast === 'postup') {
                            $rule = Rule::where('priority', 2)->where('competition_id', $competitionId)->first();
                        }

                        if ($cast === 'sestup') {
                            $rule = Rule::where('priority', 3)->where('competition_id', $competitionId)->first();
                        }
                    }
                }

                $carbon = new Carbon($datum);
                $startDatetime = $carbon->format('Y-m-d H:i:s');

                $homeTeam = Team::where('name', $tymDomaci)->where('competition_id', $competitionId)->first();
                $awayTeam = Team::where('name', $tymHoste)->where('competition_id', $competitionId)->first();

                Game::create([
                    'round' => $round,
                    'start_datetime' => $startDatetime,
                    'home_team_id' => $homeTeam->id,
                    'away_team_id' => $awayTeam->id,
                    'home_team_score' => $homeTeamScore,
                    'away_team_score' => $awayTeamScore,
                    'home_team_halftime_score' => $homeTeamHalftimeScore,
                    'away_team_halftime_score' => $awayTeamHalftimeScore,
                    'user_id' => $userId,
                    'rule_id' => $rule->id,
                    'competition_id' => $competitionId,
                ]);
            }
        } else {
            $json = File::get('database/data/games.json');
            $objects = json_decode($json);
            foreach ($objects as $object) {
                Game::create([
                    'round' => $object->round,
                    'start_datetime' => $object->start_datetime,
                    'home_team_id' => $object->home_team_id,
                    'away_team_id' => $object->away_team_id,
                    'home_team_score' => $object->home_team_score,
                    'away_team_score' => $object->away_team_score,
                    'home_team_halftime_score' => $object->home_team_halftime_score,
                    'away_team_halftime_score' => $object->away_team_halftime_score,
                    'user_id' => $object->user_id,
                    'rule_id' => $object->rule_id,
                    'competition_id' => $object->competition_id,
                ]);
            }
        }
    }
}
