<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use App\Imports\ImportQuotes;
use App\Quote;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuoteController extends Controller
{
    public function quotes()
    {
        return view('quotes.index', ['quotes' => Quote::paginate(15),'listName' => 'All Quotes' ]);
    }

    public function verified_quotes()
    {
        return view('quotes.index', ['quotes' => Quote::where('active',1)->paginate(15),'listName' => 'Verified Quotes' ]);
    }

    public function pending_quotes()
    {
        return view('quotes.index', ['quotes' => Quote::where('active',0)->paginate(15),'listName' => 'Pending Quotes' ]);
    }

    public function store(QuoteRequest $request)
    {
        $qoute = new Quote([
            'text' => $request->get('text'),
            'author' => $request->get('author'),
            'active' => $request->has('active') ? 1 : 0,
        ]);
        $qoute->save();

        return redirect()->route('quote.quotes')->withStatus(__('Quote successfully created.'));
    }

    public function seed(Request $request)
    {
        $request->validate([
            'data' => 'required|mimes:csv,txt'
        ]);

        Excel::import(new ImportQuotes(),$request->file('data'));
        return back()->with('success','Quotes imported successfully');
    }

    public function update(QuoteRequest $request, Quote $quote)
    {
        $quote->update([
            'text' => $request->get('text'),
            'author' => $request->get('author'),
            'active' => $request->get('active') ? 1 : 0,
        ]);
        return redirect()->route('quote.quotes')->withStatus(__('Quote successfully updated.'));
    }

    public function create()
    {
        return view('quotes.create');
    }

    public function edit(Quote $quote)
    {
        return view('quotes.edit', compact('quote'));
    }

    public function import()
    {
        return view('quotes.import');
    }

    public function destroy(Quote  $quote)
    {
        $quote->delete();
        return redirect()->route('quote.quotes')->withStatus(__('Quote successfully deleted.'));
    }

    public function search(Request $request)
    {
        $quotes = null;

        $activeStatus = null;
        $listName = 'All Quotes';
        if($request->get('is_active'))
        {
            switch ($request->get('is_active'))
            {
                case '1':
                    $activeStatus = "1";
                    $listName = 'Verified Quotes';
                    break;
                case '-1':
                    $activeStatus = "0";
                    $listName = 'Pending Quotes';
                    break;
            }
        }
        $phrase = $request->get('phrase') == null ? "" : $request->get('phrase');
        if($activeStatus == null)
        {

            $quotes = Quote::where($request->get('search_by') == null ? 'text' : $request->get('search_by'),'LIKE','%'.$phrase.'%')->paginate(15);
        }
        else
        {
            $quotes = Quote::where('active',$activeStatus)->where($request->get('search_by') == null ? 'text' : $request->get('search_by'),'LIKE','%'.$phrase.'%')->paginate(15);
        }

        return view('quotes.index', ['quotes' => $quotes, 'listName' => $listName]);
    }

    public function last_all_quotes(Request $request)
    {
        $resultRecords = array();
        $resultTimes = array();
        $time = today()->subDays(13);
        for ($i=0;$i<15;$i++)
        {
            $records = Quote::whereDate('created_at','<=', $time )->get();
            $resultRecords[] = $records->count();
            $resultTimes[] = $time->format('M d');
            $time->addDay();
        }
        return response()->json(['records'=>$resultRecords, 'times' => $resultTimes],200);
    }
}
