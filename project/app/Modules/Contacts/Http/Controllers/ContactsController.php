<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendContactMail;
use App\Modules\Contacts\Http\Requests\StoreContactRequest;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Charlotte\Administration\Helpers\Settings;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{
    public function index()
    {
        SEOTools::setTitle(Settings::getTranslated('contacts_title'));
        SEOTools::setDescription(Settings::getTranslated('contacts_meta_description'));
        SEOMeta::addKeyword(Settings::getTranslated('contacts_meta_keywords'));
        OpenGraph::addImage(asset('images/default_seo.jpg'), ['height' => 1200, 'width' => 630]);


        return view('contacts::front.index');
    }

    public function store(StoreContactRequest $request)
    {
        $email = Settings::get('contacts_email');

        if (!empty($email)) {
            Mail::to($email)->send(new SendContactMail($request->validated()));
        }

        return back()->withSuccess([trans('contacts::front.success')]);
    }
}
