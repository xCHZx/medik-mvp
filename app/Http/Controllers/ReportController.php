<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    //---Datos de Negocio
    //---Total dde opiniones
    //Total de Visitantes(clientes)
    //---Total de Visitas
    //---Conteo de opiniones positivas
    //---Conteo de opiniones negativas
    //---Variación porcentual de opiniones respecto al mes anterior
    //---Variación porcentual de visitas respecto al mes anterior
    //Variación porcentual de visitantes respecto al mes anterior

    //Por periodo
    //---Total de opiniones
    //Total de Visitantes(clientes)
    //---Total de Visitas
    //---Conteo de opiniones positivas
    //---Conteo de opiniones negativas
    //Flujos enviados
    //Flujos inconclusos

    public function index(Request $request){ //Falta optimizar para enviar solo los datos específicos
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        $id = Auth::user()->id;

        if ($startDate && $endDate){
            $allReviewsByPeriod = Business::find($id)->reviews()->whereDate('reviews.created_at', '>=', $startDate)->whereDate('reviews.created_at', '<=', $endDate)->get();
            $badReviewsByPeriod = Business::find($id)->reviews()->whereDate('reviews.created_at', '>=', $startDate)->whereDate('reviews.created_at', '<=', $endDate)->where('rating', '<=', 3)->get();
            $goodReviewsByPeriod = Business::find($id)->reviews()->whereDate('reviews.created_at', '>=', $startDate)->whereDate('reviews.created_at', '<=', $endDate)->where('rating', '>=', 4)->get();
            $allVisitsByPeriod = Business::find($id)->visits()->whereDate('visits.created_at', '>=', $startDate)->whereDate('visits.created_at', '<=', $endDate)->get();
        } else {
            $allReviewsByPeriod = Business::find($id)->reviews()->get();
            $allVisitsByPeriod = Business::find($id)->visits()->get();
            $badReviewsByPeriod = Business::find($id)->reviews()->where('rating', '<=', 3)->get();
            $goodReviewsByPeriod = Business::find($id)->reviews()->where('rating', '>=', 4)->get();
        }

        // $allVisitors = Business::where('id', $id)
        // ->with('visits.visitor')
        // ->get()
        // ->pluck('visits')
        // ->flatten()
        // ->pluck('visitor');
        $allReviews = Business::find($id)->reviews()->get();
        $goodReviews = Business::find($id)->reviews()->where('rating', '>=', 4)->get();
        $badReviews = Business::find($id)->reviews()->where('rating', '<=', 3)->get();
        $allVisits = Business::find($id)->visits()->get();


        $currentMonthReviews = Business::find($id)
                                ->reviews()
                                ->whereDate('reviews.created_at', '>=', now()->subDays(30))
                                ->orderBy('created_at', 'desc')
                                ->get();

        $lastMonthReviews = Business::find($id)
                                ->reviews()
                                ->whereDate('reviews.created_at', '<', now()->subDays(30))
                                ->orderBy('created_at', 'desc')
                                ->get();

        //Operación para conocer porcentaje de variación entre currentMonthReviews y lastMonthReviews
        $lastMonthReviewsVariation = 0;
        if ($lastMonthReviews->count() > 0) {
            $lastMonthReviewsVariation = (($currentMonthReviews->count() - $lastMonthReviews->count()) / $lastMonthReviews->count()) * 100;
        }

        $currentMonthVisits = Business::find($id)
        ->visits()
        ->whereDate('visits.created_at', '>=', now()->subDays(30))
        ->orderBy('created_at', 'desc')
        ->get();

        $lastMonthVisits = Business::find($id)
        ->visits()
        ->whereDate('visits.created_at', '<', now()->subDays(30))
        ->orderBy('created_at', 'desc')
        ->get();

        $lastMonthVisitsVariation = 0;
        if ($lastMonthVisits->count() > 0) {
            $lastMonthReviewsVariation = (($currentMonthVisits->count() - $lastMonthVisits->count()) / $lastMonthVisits->count()) * 100;
        }


        $business = Business::with(['reviews'=>function($query){
            $query->orderByDesc('id');
        },'visits'=>function($query){
            $query->orderByDesc('id');
        }])->where('id', Auth::user()->id)->first();



        // $this->getPercentageVariation($business->id);


        return view('dashboard.reports.index', compact(
            'business',
            'allReviews',
            'goodReviews',
            'badReviews',
            'lastMonthReviewsVariation',
            'allReviewsByPeriod',
            'goodReviewsByPeriod',
            'badReviewsByPeriod',
            'allVisits',
            'lastMonthVisitsVariation',
            'allVisitsByPeriod',
        ));
    }
    // public function getPercentageVariation($reviews) {
    //     $currentMonthReviews = Review::whereMonth('created_at', date('m'))
    //                                  ->whereYear('created_at', date('Y'))
    //                                  ->count();

    //     $previousMonthReviews = Review::whereMonth('created_at', date('m', strtotime('-1 month')))
    //                                   ->whereYear('created_at', date('Y', strtotime('-1 month')))
    //                                   ->count();

    //     if ($previousMonthReviews == 0) {
    //         return "No reviews in the previous month to calculate variation.";
    //     }

    //     $percentageVariation = (($currentMonthReviews - $previousMonthReviews) / $previousMonthReviews) * 100;

    //     return $percentageVariation;
    // }

}
