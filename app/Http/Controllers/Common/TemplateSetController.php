<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\helpdesk\TemplateSetRequest;
use App\Model\Common\Template;
use App\Model\Common\TemplateSet;
use Exception;
use Illuminate\Http\Request;
use Lang;

class TemplateSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $tempcon = new TemplateController();
        $this->tempcon = $tempcon;
    }

    /**
     * get the list of template sets.
     *
     * @return type view
     */
    public function index()
    {
        try {
            $sets = TemplateSet::all();

            return view('themes.default1.common.template.sets', compact('sets'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateSet $sets, TemplateSetRequest $request)
    {
        try {
            $sets->name = $request->input('name');
            $sets->save();
            $templates = Template::where('set_id', '=', '1')->get();
            foreach ($templates as $template) {
                \DB::table('templates')->insert(['set_id' => $sets->id, 'name' => $template->name, 'variable' => $template->variable, 'type' => $template->type, 'subject' => $template->subject, 'message' => $template->message]);
            }

            return redirect('template-sets')->with('success', Lang::get('lang.you_have_created_a_new_template_set'));
        } catch (Exception $ex) {
            return redirect('template-sets')->with('fails', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function activateSet($id)
    {
        try {
            if (strpos($id, '_') !== false) {
                $ratName = str_replace('_', ' ', $id);
            } else {
                $ratName = $id;
            }
            \DB::table('settings_email')->update(['template' => $ratName]);

            return \Redirect::back()->with('success', Lang::get('lang.you_have_successfully_activated_this_set'));
        } catch (Exception $ex) {
            return \Redirect::back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $this->tempcon->showTemplate($id);
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteSet($id)
    {
        try {
            $templates = Template::where('set_id', '=', $id)->get();
            foreach ($templates as $template) {
                $template->delete();
            }
            TemplateSet::whereId($id)->delete();

            return redirect()->back()->with('success', Lang::get('lang.template_set_deleted_successfully'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
