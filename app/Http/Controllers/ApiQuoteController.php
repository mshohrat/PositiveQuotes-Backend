<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use App\Quote;
use Illuminate\Http\Request;

class ApiQuoteController extends Controller
{
    public function createQuote(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'author' => 'nullable|string'
        ]);
        $quote = new Quote([
            'text' => $request->text,
            'author' => $request->author,
            'active' => false,
        ]);
        $quote->save();
        return response()->json($quote, 201);
    }

    public function createQuoteByAdmin(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'author' => 'nullable|string'
        ]);
        $quote = new Quote([
            'text' => $request->text,
            'author' => $request->author,
            'active' => true,
        ]);
        $quote->save();
        return response()->json($quote, 201);
    }

    public function editQuoteByAdmin(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'author' => 'nullable|string',
            'active' => 'nullable|boolean'
        ]);
        $quote = Quote::where('id',$request->route('id'))->first();
        if($quote != null)
        {
            $quote->text = $request->text;
            $quote->author = $request->author;
            $quote->active = $request->active;
            $quote->save();
            return ResponseUtil::handleMessageResponse('Successfully updated Quote!',ResponseUtil::SUCCESS);
        }
        return ResponseUtil::handleMessageResponse('Quote not found!',ResponseUtil::NOT_FOUND);
    }

    public function deleteQuote(Request $request)
    {
//        $quote = Quote::where('id',$request->route('id'))->first();
//        if($quote != null)
//        {
//            $quote->text = $request->text;
//            $quote->author = $request->author;
//            $quote->active = $request->active;
//            $quote->save();
//            return response()->json(['message' => 'Successfully updated Quote!'], 200);
//        }
//        return response()->json(['message' => 'Quote not found!'], 404);
    }

    public function deleteQuoteByAdmin(Request $request)
    {
        $quote = Quote::where('id',$request->route('id'))->first();
        if($quote != null)
        {
            $quote->delete();
            return ResponseUtil::handleMessageResponse('Successfully deleted Quote!',ResponseUtil::SUCCESS);
        }
        return ResponseUtil::handleMessageResponse('Quote not found!',ResponseUtil::NOT_FOUND);
    }

    public function activateQuoteByAdminInDB(string $id,string $active) : bool
    {
        $quote = Quote::where('id',$id)->first();
        if($quote != null)
        {
            $quote->active = $active == "1";
            $quote->save();
            return true;
        }
        return false;
    }

    public function makeQuoteActiveByAdmin(Request $request)
    {
        if($this->activateQuoteByAdminInDB($request->route('id'),$request->route('active')))
        {
            return ResponseUtil::handleMessageResponse('Successfully updated Quote!',ResponseUtil::SUCCESS);
        }
        return ResponseUtil::handleMessageResponse('Quote not found!',ResponseUtil::NOT_FOUND);
    }

    public function makeQuotesActiveByAdmin(Request $request)
    {
        $request->validate([
            'quotes' => 'nullable|array',
        ]);
        $done = false;
        foreach ($request->quotes as $key => $value)
        {
            $done = $this->activateQuoteByAdminInDB($key,$value);
        }

        if($done)
        {
            return ResponseUtil::handleMessageResponse('Successfully updated Quote!',ResponseUtil::SUCCESS);
        }
        return ResponseUtil::handleMessageResponse('Quote not found!',ResponseUtil::NOT_FOUND);
    }

    public function getQuote()
    {

    }

    public function getQuotesByAdmin()
    {

    }
}
