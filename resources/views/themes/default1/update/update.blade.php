@extends('themes.default1.admin.layout.admin')
@section('content')
<div class="box box-primary">
    <div class="row">
        <div class="col-md-12">
            <div class="box-body">

                <p>CURRENT VERSION: {{$current_version}}</p>
                <p>Reading Current Releases List</p>

                <?php
                $updated = false;
                $controller = new \App\Http\Controllers\Update\UpgradeController();
                if ($latest_version > $current_version) {
                    echo '<p>New Update Found: v' . $latest_version . '</p>';
                    $found = true;
                    if (!is_file("$controller->dir/UPDATES/faveo-helpdesk-master.zip")) {
                        if (key_exists("dodownload", $_GET) && $_GET["dodownload"] == true) {
                            $download_url = $controller->downloadLatestCode();
                            if ($download_url != null) {
                                $controller->saveLatestCodeAtTemp($download_url);
                            } else {
                                echo '<p>Error in you network connection.</p>';
                                //exit();
                            }
                        } else {
                            echo '<p>Latest code found. <a href=' . url('file-upgrade?dodownload=true') . '>&raquo; Download Now?</a></p>';
                            //exit();
                        }
                    } else {
                        echo '<p>Update ready. <a href=' . url('file-upgrade?doUpdate=true') . '>&raquo; Install Now?</a></p>';
                        //echo '<p>Update already downloaded.</p>';
                    }
                    if ($request->get('doUpdate') == true) {
                        $updated = $controller->doUpdate();
                    }

                    if ($updated == true) {
                        $controller->copyToActualDirectory($latest_version);
                    } elseif ($found != true) {
                        echo '<p>&raquo; No update is available.</p>';
                    }
                } else
                    echo '<p>Could not find latest realeases.</p>';
                ?>
                
            </div>
        </div>
    </div>
</div>
@stop