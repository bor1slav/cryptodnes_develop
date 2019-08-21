<?php

namespace App\Modules\Subscribers\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\BookSubscriberMail;
use App\Mail\NewSubscriberMail;
use App\Modules\Subscribers\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscribersController extends Controller
{
    public function store(Request $request)
    {
        $errors = [];
        $success = trans('subscribers::front.success');

        $exist = Subscriber::where('email', $request->get('email'))->first();

        if ($exist) {
            $errors[] = trans('subscribers::front.already_exists');
        }

        if (!filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $errors[] = trans('subscribers::front.invalid_email');
        }

        if (empty($errors)) {
            $subscriber = new Subscriber();
            $subscriber->email = $request->get('email');
            $subscriber->save();


            Mail::to($request->get('email'))->send(new NewSubscriberMail($request->get('email')));
        }

        return response()->json(['success' => $success, 'errors' => $errors]);
    }

    public function storeBookSubscription(Request $request)
    {
//        $email = 'test@abv.bg';
//        return view('subscribers::emails.new_book_subscriber', compact('email'));
        $errors = [];
        $success = trans('subscribers::front.success');

        $exist = Subscriber::where('email', $request->get('email'))->first();


        if (!filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $errors[] = trans('subscribers::front.invalid_email');
        }

        if ($exist) {
            return response()->json(['success' => $success, 'errors' => $errors]);
            //$errors[] = trans('subscribers::front.already_exists');
        }

        if (empty($errors)) {
            $subscriber = new Subscriber();
            $subscriber->email = $request->get('email');
            $subscriber->save();


            Mail::to($request->get('email'))->send(new BookSubscriberMail($request->get('email')));
        }

        return response()->json(['success' => $success, 'errors' => $errors]);
    }

    public function unsubscribe($email) {
        $exist = Subscriber::where('email', $email)->first();

        if ($exist) {
            $exist->delete();
        }

        return redirect()->route('index');
    }
}
