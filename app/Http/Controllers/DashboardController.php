<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

    public function index()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $status = $user->subscribed('default');

        $activeBusiness = Business::where('userId', $id)->select('name','description','address','averageRating')->first();
        if (!$activeBusiness) {
            return redirect()->route('business.index'); //FALTA MANDAR UN SWAL QUE INDIQUE EL ERROR
        }

        $activeFlow = Business::where('userId', $id)->first()->flows()->where('isActive', 1)->first();
        if (!$activeFlow) {
            return redirect()->route('flows.index'); //FALTA MANDAR UN SWAL QUE INDIQUE EL ERROR
        }

            //Get the last 3 reviews
            $lastReviews = Business::where('userId', $id)->first()
                ->reviews()
                ->where('status', 'Finalizada')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            $allVisits = Business::where('userId', $id)->first()->visits()->get();

            $allReviews = Business::where('userId', $id)->first()->reviews()->where('status', 'Finalizada')->get();
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
                ->where('status', 'Finalizada')
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
            'activeFlow', //Flujo activo
            'lastReviews', //Últimas 3 opiniones
            'allVisits', //Todas las visitas
            'allReviews', //Todas las opiniones
            'goodReviews', //Opiniones positivas
            'badReviews', //Opiniones negativas
            'goodReviewsLastMonth', //Opiniones positivas de los últimos 30 días
            'badReviewsLastMonth', //Opiniones negativas de los últimos 30 días
            'currentMonthReviews',
            'lastMonthReviews',
            'lastMonthReviewsVariation', //Variación de opiniones de los últimos 30 días
            'currentMonthVisits', //Visitas de los últimos 30 días
            'lastMonthVisits',
            'currentMonthVisits',
            'lastMonthVisitsVariation', //Variación de visitas de los últimos 30 días
        ));
    }
}
