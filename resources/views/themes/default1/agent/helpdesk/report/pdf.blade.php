<!DOCTYPE html>
<html>
    <head>
        <title>PDF</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            * {
                font-family: "DejaVu Sans Mono", monospace;
            }
        </style>
        <link href="{{asset("lb-faveo/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
    </head>
    <body>    

        <div style="background-color:#F2F2F2;">
            <h2>
                <div id="logo" class="site-logo text-center" style="font-size: 30px;">
                    <?php
                    $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                    $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
                    ?>
                    <center>
                        @if($system->url)
                        <a href="{!! $system->url !!}" rel="home">
                            @else
                            <a href="{{url('/')}}" rel="home" style="text-decoration:none;">
                                @endif
                                @if($company->use_logo == 1)
                                <img src="{!! public_path().'/uploads/company'.'/'.$company->logo !!}" width="100px;"/>
                                @else
                                @if($system->name)
                                {!! $system->name !!}
                                @else
                                <b>SUPPORT</b> CENTER
                                @endif
                                @endif
                            </a>
                    </center>
                </div>
            </h2>
        </div>
        <br/><br/>
        <?php $help_topic_name = App\Model\helpdesk\Manage\Help_topic::where('id', '=', $table_help_topic)->first(); ?>
        <span class="lead"> Help Topic : {!! $help_topic_name->topic !!} </span>
        <br/>
        
        Date Range : {!! reset($table_datas[0]) !!} --- {!! end($table_datas)->date !!}
        <br/><br/>
        <span class="lead">SUMMARY</span>
        <table class="table table-striped" style="font-size:8;">
            <thead>
                <tr>
                    <td>Date</td>
                    @if(array_key_exists(1, $table_datas) && $table_datas[1]->open)
                    <td>Created</td>
                    @endif
                    @if(array_key_exists(1, $table_datas) && $table_datas[1]->closed)
                    <td>Closed</td>
                    @endif
                    @if(array_key_exists(1, $table_datas) && $table_datas[1]->reopened)
                    <td>Reopened</td>
                    @endif
                </tr>
            </thead>
            <tbody>
                <?php
//dd($table_datas[1]);
                $table_open = 0;
                $table_closed = 0;
                $table_reopened = 0;
                foreach ($table_datas as $table_data) {
                    echo '<tr>';
                    echo '<td>' . $table_data->date . '</td>';
                    if ($table_data->open) {
                        echo '<td>' . $table_data->open . '</td>';
                        $table_open += $table_data->open;
                    }
                    if ($table_data->closed) {
                        echo '<td>' . $table_data->closed . '</td>';
                        $table_closed += $table_data->closed;
                    }
                    if ($table_data->reopened) {
                        echo '<td>' . $table_data->reopened . '</td>';
                        $table_reopened += $table_data->reopened;
                    }
                    echo '</tr>';
                }
                ?>          
            </tbody>
        </table>

        <table>
            <tr>
                @if(array_key_exists(1, $table_datas))
                <td>
                    <span style="color:#F7CF07;">TOTAL IN PROGRESS</span> : {!! $table_datas[1]->inprogress !!}
                </td>
                @endif
                <td>
                    @if($table_data->open)
                    <span style="color:blue;">TOTAL CREATED</span>  : {!! $table_open !!}
                    @endif
                </td>
                <td>
                    @if($table_data->reopened)
                    <span style="color:orange;">TOTAL REOPENED</span>  : {!! $table_reopened !!}
                    @endif
                </td>
                <td>
                    @if($table_data->closed)
                    <span style="color:#00e765;">TOTAL CLOSED</span> : {!! $table_closed !!}
                    @endif    
                </td>
            </tr>
        </table>    


    </body>
</html>