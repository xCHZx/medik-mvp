<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /*
        ---Nuevos clientes/nuevas visitas del último mes
        ---Total de opiniones positivas
        ---Total de opiniones negativas
        ---Opiniones positivvas del último mes
        ---Opiniones negativas del último mes
        ---Total de clientes/visitas
        ---Incremento de clientes/visitas del último mes
        ---Total Opiniones
        ---Incremento de opiniones del último mes
        ---Últimas 3 opiniones (objeto)
        ---Negocio activo
        ---Flujo activo
    */

    public function index(){
        $user = Auth::user();
        $id = Auth::user()->id;
        $status = $user->subscribed('default');

        $activeBusiness = Business::where('userId', $id)->first();
        $activeFlow = Business::where('userId', $id)->first()->flows()->where('isActive', 1)->first();

        //Get the last 3 reviews
        $lastReviews = Business::where('userId', $id)->first()
        ->reviews()
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

        $allVisits = Business::where('userId', $id)->first()->visits()->get();

        $allReviews = Business::where('userId', $id)->first()->reviews()->get();
        $goodReviews = Business::where('userId', $id)->first()->reviews()->where('rating', '>=', 4)->get();
        //good reviews of the last 30 days
        $goodReviewsLastMonth = Business::where('userId', $id)->first()
        ->reviews()
        ->where('rating', '>=', 4)
        ->whereDate('reviews.created_at', '>=', now()->subDays(30))
        ->orderBy('created_at', 'desc')
        ->get();

        //bad reviews of the last 30 days
        $badReviewsLastMonth = Business::where('userId', $id)->first()
        ->reviews()
        ->where('rating', '<=', 3)
        ->whereDate('reviews.created_at', '>=', now()->subDays(30))
        ->orderBy('created_at', 'desc')
        ->get();



        $badReviews = Business::where('userId', $id)->first()->reviews()->where('rating', '<=', 3)->get();

        $currentMonthVisits = Business::where('userId', $id)->first()
        ->visits()
        ->whereDate('visits.created_at', '>=', now()->subDays(30))
        ->orderBy('created_at', 'desc')
        ->get();

        $lastMonthVisits = Business::where('userId', $id)->first()
        ->visits()
        ->whereDate('visits.created_at', '<', now()->subDays(30))
        ->orderBy('created_at', 'desc')
        ->get();

        $lastMonthVisitsVariation = 0;
        if ($lastMonthVisits->count() > 0) {
            $lastMonthReviewsVariation = (($currentMonthVisits->count() - $lastMonthVisits->count()) / $lastMonthVisits->count()) * 100;
        }


        $currentMonthReviews = Business::where('userId', $id)->first()
                                ->reviews()
                                ->whereDate('reviews.created_at', '>=', now()->subDays(30))
                                ->orderBy('created_at', 'desc')
                                ->get();

        $lastMonthReviews = Business::where('userId', $id)->first()
                                ->reviews()
                                ->whereDate('reviews.created_at', '<', now()->subDays(30))
                                ->orderBy('created_at', 'desc')
                                ->get();

        //Operación para conocer porcentaje de variación entre currentMonthReviews y lastMonthReviews
        $lastMonthReviewsVariation = 0;
        if ($lastMonthReviews->count() > 0) {
            $lastMonthReviewsVariation = (($currentMonthReviews->count() - $lastMonthReviews->count()) / $lastMonthReviews->count()) * 100;
        }



        return view('dashboard.dashboard.index', compact(
            'user',
            'status',
            'activeBusiness',
            'activeFlow',
            'lastReviews',
            'allVisits',
            'allReviews',
            'goodReviews',
            'badReviews',
            'goodReviewsLastMonth',
            'badReviewsLastMonth',
            'currentMonthReviews',
            'lastMonthReviews',
            'lastMonthReviewsVariation',
            'currentMonthVisits',
            'lastMonthVisitsVariation',
            'lastMonthVisits',
            'currentMonthVisits',
            'lastMonthVisitsVariation',
        ));
    }
}
