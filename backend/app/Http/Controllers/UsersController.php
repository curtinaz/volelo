<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $req) {

        if($req->search) {
            $users = User::where("name", "like", "%$req->search%")->get();
        } else {
            $users = User::all();
        }

        return $users;
    }

    public function newUser(Request $req) {
        $user = User::create([
            "name" => $req->name,
        ]);

        $user->save();
        return $user;
    }

    public static function balancer(Request $req) {
        $players = [];
        for ($i = 0; $i < count($req->players); $i++) {
            $player = User::find($req->players[$i]['id']);
            if ($player) {
                array_push($players, $player);
            }
        }

        // Ordenar os jogadores por rating (do maior para o menor)
        usort($players, function ($a, $b) {
            return $b->rating - $a->rating;
        });

        $team1 = [];
        $team2 = [];
        $sumTeam1 = 0;
        $sumTeam2 = 0;

        // Adicionar jogadores ao time com a menor soma de ratings
        foreach ($players as $player) {
            if ($sumTeam1 <= $sumTeam2) {
                $team1[] = $player;
                $sumTeam1 += $player->rating;
            } else {
                $team2[] = $player;
                $sumTeam2 += $player->rating;
            }
        }

        return [
            "team1" => [
                "players" => $team1,
                "totalRating" => $sumTeam1
            ],
            "team2" => [
                "players" => $team2,
                "totalRating" => $sumTeam2
            ]
        ];
    }

    public function atualizarElo(Request $req) {
        $time1 = $req->team1;
        $time2 = $req->team2;

        $playersTime1 = [];
        for ($i = 0; $i < count($req->team1); $i++) {
            $player = User::find($req->team1[$i]);
            if ($player) {
                array_push($playersTime1, $player);
            }
        }

        $playersTime2 = [];
        for ($i = 0; $i < count($req->team2); $i++) {
            $player = User::find($req->team2[$i]);
            if ($player) {
                array_push($playersTime2, $player);
            }
        }

        $resultadoEquipe1 = $req->winner == 1 ? 1 : 0;

        $novosRatingsTime1 = self::atualizarEloEquipe(array_column($playersTime1, 'rating'), array_column($playersTime2, 'rating'), $resultadoEquipe1);
        $novosRatingsTime2 = self::atualizarEloEquipe(array_column($playersTime2, 'rating'), array_column($playersTime1, 'rating'), 1 - $resultadoEquipe1);

        foreach ($playersTime1 as $index => $jogador) {
            $jogador['rating'] = $novosRatingsTime1[$index];
            $dbPlayer = User::find($jogador['id']);
            $dbPlayer->rating = $novosRatingsTime1[$index];
            $dbPlayer->save();
        }

        foreach ($playersTime2 as $index => $jogador) {
            $jogador['rating'] = $novosRatingsTime2[$index];
            $dbPlayer = User::find($jogador['id']);
            $dbPlayer->rating = $novosRatingsTime2[$index];
            $dbPlayer->save();
        }

        return [$playersTime1, $playersTime2];
    }

    public static function probabilidadeVitoriaEquipe($ratingsEquipe1, $ratingsEquipe2)
    {
        $somaRatingsEquipe1 = array_sum($ratingsEquipe1);
        $somaRatingsEquipe2 = array_sum($ratingsEquipe2);
        $probabilidadeEquipe1 = self::probabilidadeVitoria($somaRatingsEquipe1, $somaRatingsEquipe2);
        return $probabilidadeEquipe1;
    }

    // Função para calcular a probabilidade de vitória com base na diferença de rating
    private static function probabilidadeVitoria($ratingJogador1, $ratingJogador2)
    {
        return 1 / (1 + pow(10, ($ratingJogador2 - $ratingJogador1) / 400));
    }

    // Função para atualizar as pontuações Elo de uma equipe após uma partida
    public static function atualizarEloEquipe($ratingsEquipe1, $ratingsEquipe2, $resultadoEquipe1)
    {
        $novosRatings = [];
        $resultadoEquipe2 = 1 - $resultadoEquipe1;
        foreach ($ratingsEquipe1 as $index => $rating) {
            $K = 32; // Fator de escala (pode ser ajustado conforme necessário)
            $probabilidadeEquipe1 = self::probabilidadeVitoriaEquipe($ratingsEquipe1, $ratingsEquipe2);
            $novoRating = $rating + $K * ($resultadoEquipe1 - $probabilidadeEquipe1);
            $novosRatings[] = $novoRating;
        }
        return $novosRatings;
    }
    
    public function eloRanking()
    {
        $users = User::orderBy('rating','desc')->get(['rating', 'name']);
        return response($users);
    }
}
