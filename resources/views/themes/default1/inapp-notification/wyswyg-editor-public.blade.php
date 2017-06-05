<style>
    .drop {
    width: 170px;
    text-align: center;
    padding: 50px 10px;
    margin: auto;
    width:100%;
    min-height: 250px;
}
.input-hidden {
  position: absolute;
  left: -9999px;
}

input[type=radio]:checked + label>img {
  border: 1px solid #fff;
  box-shadow: 0 0 3px 3px #090;
}
.loader {
    margin: auto;
    margin-top: 100px;
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #3498db;
    width: 50px;
    height: 50px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<div style="margin-bottom: 9px;">
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" style="border-radius: 0px;background-color: #f0f0f0;" ng-click="getImageApi()"><i class="fa fa-caret-square-o-right" style="margin-right: 5px"></i>Add Media</button>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="min-width: 70%">

            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 0px">
                <div class="modal-header" style="border-bottom: 0px;padding-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert Media</h4>
                </div>
                <div class="modal-body" style="padding-bottom: 0px">
                    <div class="row">
                        <div class="col-sm-12" style="padding-left: 0px;padding-right: 0px;">

                            <ul class="nav nav-tabs" id="mytabs">
                                <li><a data-toggle="tab" href="#upload" ng-click="noInsert()">Upload Files</a></li>
                                <li class="active"><a data-toggle="tab" href="#menu1">Media Library</a></li>
                            </ul>
                            <div class="tab-content" style="border:1px solid #ddd;border-top: 0px;min-height: 300px;border-bottom: 0px;max-height: 350px;overflow-y: auto">
                                <div id="upload" class="tab-pane fade ">
                                    <p>
                                    <div flow-init="{target:'{{url('chunk/upload/public')}}',testChunks:false}" flow-files-submitted="$flow.upload()"  flow-file-success="someHandlerMethod( $file, $message, $flow )" flow-file-added="someHandlerMethod( $file, $event, $flow )" flow-file-error="$file.msg = $message">
                                        <table class="table">
                                            <tr ng-repeat="file in $flow.files">
                                                  <td style="color: red;">Error</td>
                                                  <td style="color: red;">@{{file.name}}</td>
                                                  <td style="color: red;">@{{file.msg}}</td>
                                            </tr>
                                        </table>
                                        <div  class="drop" flow-drop="" ng-class="dropClass">
                                            <h3>Drop File Anywhere to Upload</h3>
                                            <p>or</p>
                                            <span class="btn btn-default" flow-btn="" ng-click="check($flow)">Upload File<input type="file" multiple="multiple" style="visibility: hidden; position: absolute;"></span>            

                                            <div class="well" ng-show="$flow.files[0] != null" id="progressHide" style="margin:10px">
                                                <div ng-repeat="file in $flow.files" class="transfer-box ng-scope ng-binding">
                                                    <p>@{{file.name}}</p>
                                                    @{{file.sizeUploaded()}} kB / @{{file.size}} kB | @{{file.sizeUploaded() / file.size * 100 | number:0}}%
                                                    <div class="progress progress-striped" ng-class="{active: file.isUploading()}">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" ng-style="{width: (file.progress() * 100) + '%'}">
                                                        </div>
                                                    </div>
                                                    <div class="btn-group">
                                                        
                                                        <a class="btn btn-xs btn-warning ng-hide" ng-click="file.resume()" ng-show="file.paused">
                                                            Resume
                                                        </a>
                                                        <a class="btn btn-xs btn-danger" ng-click="file.cancel()">
                                                            Cancel
                                                        </a>
                                                        <a class="btn btn-xs btn-info" ng-click="file.retry()" ng-show="file.error">
                                                            Retry
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </p>

                                </div>
                                <div id="menu1" class="tab-pane fade in active">
                                    <div class="col-sm-12" style="padding-left: 0px;padding-right: 0px;">
                                        <div class="col-sm-9" style="padding-left: 0px;padding-right: 0px;height: 320px;overflow: auto" media-lib-scrolled="callApi()">
                                            <div class="col-sm-3" style="padding: 10px;">
                                                <select ng-change="filterApi(search)" ng-model="search.type" class="form-control" style="border-radius: 0px">
                                                    <option value="">All Media Itmes</option>
                                                    <option value="image">Image</option>
                                                    <option value="video">Video</option>
                                                    <option value="Audio">Audio</option>
                                                    <option value="doc">Document</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3" style="padding: 10px;">
                                                <select ng-change="filterApi(search)" ng-model="search.day" class="form-control" style="border-radius: 0px" >
                                                    <option value="">Day</option>
                                                    <option value="01">1</option>
	                                            <option value="02">2</option>
	                                            <option value="03">3</option>
	                                            <option value="04">4</option>
	                                            <option value="05">5</option>
	                                            <option value="06">6</option>
	                                            <option value="07">7</option>
	                                            <option value="08">8</option>
	                                            <option value="09">9</option>
	                                            <option value="10">10</option>
	                                            <option value="11">11</option>
	                                            <option value="12">12</option>
	                                            <option value="13">13</option>
	                                            <option value="14">14</option>
	                                            <option value="15">15</option>
	                                            <option value="16">16</option>
	                                            <option value="17">17</option>
	                                            <option value="18">18</option>
	                                            <option value="19">19</option>
	                                            <option value="20">20</option>
	                                            <option value="21">21</option>
	                                            <option value="22">22</option>
	                                            <option value="23">23</option>
	                                            <option value="24">24</option>
	                                            <option value="25">25</option>
	                                            <option value="26">26</option>
	                                            <option value="27">27</option>
	                                            <option value="28">28</option>
	                                            <option value="29">29</option>
	                                            <option value="30">30</option>
	                                            <option value="31">31</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3" style="padding: 10px;">
                                                <select ng-change="filterApi(search)" ng-model="search.month" class="form-control" style="border-radius: 0px">
                                                    <option value="">Month</option>
                                                    <option value="01">January</option>
	                                            <option value="02">Febuary</option>
	                                            <option value="03">March</option>
	                                            <option value="04">April</option>
	                                            <option value="05">May</option>
	                                            <option value="06">June</option>
	                                            <option value="07">July</option>
	                                            <option value="08">August</option>
	                                            <option value="09">September</option>
	                                            <option value="10">October</option>
	                                            <option value="11">November</option>
	                                            <option value="12">December</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3" style="padding: 10px;">
                                                <select ng-change="filterApi(search)" ng-model="search.year" class="form-control" style="border-radius: 0px">
                                                    <option value="">Year</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                </select>
                                            </div>
                                            <ul class="list-inline row">
                                                <li class="col-sm-3" ng-repeat="object in arrayImage.data|filter:{'type':  search.type}" style="margin: 25px;height: 200px;" ng-click="insert(object.type,object.base_64,object.pathname,object.filename)">
                                                    <input type="radio" name="selection" id="happy@{{$index}}" ng-model="$parent.selection" class="input-hidden" ng-value="@{{$index}}"/>
                                                    <label for="happy@{{$index}}" ng-switch="object.type">
                                                        
                                                        <img ng-switch-when="image" ng-src="@{{object.base_64}}"  width="150px" height="150px" style="vertical-align: inherit;" />
                                                        <img  ng-switch-when="audio" src="{{asset('lb-faveo/media/images/audio.png')}}"   width="150px" height="150px" style="vertical-align: inherit;" />
                                                        <img  ng-switch-when="video" src="{{asset('lb-faveo/media/images/video.png')}}" width="150px" height="150px" style="vertical-align: inherit;" />
                                                        <img  ng-switch-default src="{{asset('lb-faveo/media/images/common.png')}}" width="150px" height="150px" style="vertical-align: inherit;" />
                                                        <img  ng-switch-when="text" src="{{asset('lb-faveo/media/images/txt.png')}}" width="150px" height="150px" style="vertical-align: inherit;" />
                                                        
                                                        <p style="display: flex;width: 120px;overflow-y: hidden;word-wrap: break-word;flex-direction: column;text-align: center;margin-left: 13px">@{{object.filename}}</p>
                                                    </label>
                                                </li>
                                                <li class="col-sm-3" ng-show="api2Called">
                                                    <div class="loader"></div>
                                                </li>
                                                <div class="loader" ng-hide="apiCalled"></div>
                                            </ul>
                                        </div>
                                        <div class="col-sm-3" style="padding-left: 0px;padding-right: 0px;border-left:1px solid #ddd;text-align: center;">
                                            <div style="min-height: 330px;">
                                                <div ng-show="preview" style="margin-top:15px">
                                                    <h3>Preview</h3>
                                                    <img ng-src="@{{viewImage}}" alt="" width="130px" height="130px" style="display: block;margin-bottom: 20px;margin-left: 20%;">
                                                    <p style="word-wrap: break-word;">@{{fileName}}</p>
                                                    <label>Path</label><input type="text" name="" class="form-control" value="" ng-model="pathName" style="display: inline-block;width:95%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-md" ng-disabled="inlineImage" data-dismiss="modal" ng-click="pushImage()">Inline</button>
                    <button type="button" class="btn btn-info btn-md" ng-disabled="disable" data-dismiss="modal" ng-click="pushToEditor()">Attach</button>
                </div>
            </div>

        </div>
    </div>

</div>
