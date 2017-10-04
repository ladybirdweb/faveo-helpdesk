<?php

namespace App\Location\Controllers\Location;

// use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
// use App\Location\Models\Assets\SdLocations;
// use App\Location\Models\Changes\SdLocationcategories;

use App\Model\helpdesk\Agent\Department;
// use App\Plugins\ServiceDesk\Requests\CreateLocationRequest;
// use Exception;
use Illuminate\Http\Request;
use Lang;

use App\Http\Controllers\Controller;
use App\Model\helpdesk\Settings\CommonSettings;
use Exception;
use App\Location\Models\Location;
use Auth;
use DB;
// use Illuminate\Http\Request;
use App\Location\Requests\LocationRequest;
use App\Location\Requests\LocationUpdateRequest;
use App\Model\helpdesk\Ticket\Ticket_source;
class LocationController extends Controller {


    /**
     * 
     * @return type
     */
    public function index() {
        try {
           $locations=Location::all();
           // dd( $locations);
            return view('location::location.index',compact('locations'));

        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * 
     * @return type
     */
    public function getLocation() {
        try {
            $location = Location::all();
            
            // $locationcategory = $location->select('id',  'title', 'email', 'phone', 'address', 'status')->get();
         
            return \Datatable::Collection($locationcategory)
                          
                            ->showColumns('title', 'email', 'phone', 'address')
                            ->addColumn('action', function($model) {
                                return "<a href=" . url('helpdesk/location-types/' . $model->id . '/edit') . " class='btn btn-primary btn-xs'> <i class='fa fa-edit' style='color:white;'>&nbsp;&nbsp;Edit</a> 


                                <a href=" . url('helpdesk/location-types/' . $model->id . '/show') . " class='btn btn-primary btn-xs'><i class='fa fa-eye' style='color:white;'>&nbsp;&nbsp;View</a>";
                            })
                            ->searchColumns('title', 'email', 'phone', 'address')
                            ->orderColumns( 'title', 'email', 'phone', 'address')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * 
     * @return type
     */
    public function create() {
        try {
            $departments = Department::all(array('id', 'name'));
          
            $organizations = \App\Model\helpdesk\Agent_panel\Organization::pluck('name', 'id')->toArray();
            return view('location::location.create', compact('departments', 'organizations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * 
     * @param CreateLocationRequest $request
     * @return type
     */
    public function handleCreate(LocationRequest $request) {

        try {
        
            $hd_location = new Location;
            $hd_location->title = $request->title;
            $hd_location->email = $request->email;
            $hd_location->phone = $request->phone;
            $hd_location->address = $request->address;
            $hd_location->save();

           
            return \Redirect::route('helpdesk.location.index')->with('message',Lang::get('lang.location_created_successfully'));
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function edit($id) {
        try {
            
            $hd_location = Location::findOrFail($id);
          
            return view('location::location.edit', compact('hd_location'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * 
     * @param CreateLocationRequest $request
     * @return type
     */
    public function handleEdit($id,LocationUpdateRequest $request) {
        try {
            
            $hd_location = Location::findOrFail($id);
            $hd_location->email = $request->email;
            $hd_location->title = $request->title;
            $hd_location->phone = $request->phone;
            $hd_location->address = $request->address;
          
            $hd_location->save();
            return \Redirect::route('helpdesk.location.index')->with('message',Lang::get('lang.location_updated_successfully'));
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function handledelete($id) {
        try {

          $check_location=Ticket_source::where('location','=',$id)->count();

            if($check_location>0){
               return redirect()->back()->with('fails',Lang::get('lang.this_location_already_applyed_in_ticket_source_you_can_not_delete_this_location'));
             }
          
            $sd_location = Location::findOrFail($id);
            $sd_location->delete();
            return \Redirect::route('helpdesk.location.index')->with('message',Lang::get('lang.location_deleted_successfully'));
        } catch (Exception $ex) {
           
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function show($id) {
        try {
            $locations = new SdLocations();
            $location = $locations->find($id);
            if ($location) {
                return view('service::location.show', compact('location'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getLocationsForForm(Request $request) {
        $html = "<option value=''>Select</option>";
        $orgid = $request->input('org');
        $location = $this->getLocationsByOrg($orgid);
        $locations = $location->pluck('title', 'id')->toArray();
        if (count($locations) > 0) {
            foreach ($locations as $key => $value) {
                $html .= "<option value='" . $key . "'>" . $value . "</option>";
            }
        }
        return $html;
    }

    public function getLocationsByOrg($orgid) {
        $location = new SdLocations();
        $locations = $location->where('organization', $orgid);
        return $locations;
    }

}
