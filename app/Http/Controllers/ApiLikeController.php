<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use App\LikeQuote;
use App\Quote;
use Illuminate\Http\Request;

class ApiLikeController extends Controller
{
    //
    public function getLikes(Request $request) {
        $page = $request->route('page');
        $likes = LikeQuote::where('user_id',$request->user()->id)->paginate(15);
        $data = [
            'current_page' => $likes->currentPage(),
            'total_pages' => $likes->lastPage(),
            'data' => $likes->getCollection()
        ];
        return ResponseUtil::handleResponse($data,ResponseUtil::SUCCESS);
    }

    public function like(Request $request) {
        $quoteId = $request->route('id');
        $quote = Quote::find($quoteId)->first();
        if($quote != null) {
            $oldLike = LikeQuote::where('quote_id',$quote->id)->first();
            if($oldLike == null)
            {
                $newLike = new LikeQuote([
                    'user_id' => $request->user()->id,
                    'quote_id' => $quote->id,
                ]);
                $newLike->save();
                return ResponseUtil::handleMessageResponse("The quote liked by user successfully",ResponseUtil::SUCCESS);
            }
            else
            {
                return ResponseUtil::handleMessageResponse('The quote is already liked by user',ResponseUtil::BAD_REQUEST);
            }
        }
        else
        {
            return ResponseUtil::handleMessageResponse("The quote not exists",ResponseUtil::NOT_FOUND);
        }
    }

    public function dislike(Request $request) {
        $quoteId = $request->route('id');
        $quote = Quote::find($quoteId)->first();
        if($quote != null) {
            $oldLike = LikeQuote::where('quote_id',$quote->id)->first();
            if($oldLike == null)
            {
                return ResponseUtil::handleMessageResponse('The quote is not liked by user',ResponseUtil::BAD_REQUEST);
            }
            else
            {
                $oldLike->forceDelete();
                return ResponseUtil::handleMessageResponse("The quote removed from user likes successfully",ResponseUtil::SUCCESS);
            }
        }
        else
        {
            return ResponseUtil::handleMessageResponse("The quote not exists",ResponseUtil::NOT_FOUND);
        }
    }
}
