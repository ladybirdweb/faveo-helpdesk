@extends('themes.default1.installer.layout.installer')

@section('licence')
done
@stop

@section('environment')
done
@stop

@section('database')
done
@stop

@section('locale')
done
@stop

@section('ready')
active
@stop

@section('content')

        <a class="twitter-share-button" target="_blank" href="https://twitter.com/intent/tweet?text=I just set up a new HELPDESK with @faveohelpdesk! http://www.faveohelpdesk.com #helpdesk">
            <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQ-uhinU3OzXKj9zlFO7dFxHaChqyHPcWWg5nWgMqYt6N5b3knK" style="width: 86px; float: right;">
        </a>

        <h1 style="text-align: center;">Thank you</h1>


        <div class="wc-setup-next-steps">
            <div class="wc-setup-next-steps-first">
                <h2>Next Steps</h2>
                <ul>
                    <li class="setup-product"><a class="button button-primary button-large" href="{!! url('auth/login') !!}" style="float: none; text-align: center; font-size: 24px;    padding: 15px;     line-height: 1;">Login to Faveo</a>
                    </li>
                </ul>
            </div>
            <div class="wc-setup-next-steps-last">
                <h2>Learn More</h2>
                <ul>
                    <li class="video-walkthrough"><a target="_blank" href="https://www.youtube.com/channel/UC-eqh-h241b1janp6sU7Iiw">Video walk through</a>
                    </li>
                    <li class="sidekick"><a target="_blank" href="http://www.ladybirdweb.com/support/knowledgebase">Knowledge Base</a>
                    </li>

                    <li class="newsletter"><a href="mailto:support@ladybirdweb.com">Email Support</a>
                    </li>
                    <br>
                    <br>
                    <br>
                </ul>
            </div>
        </div>


    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="{{asset("lb-faveo/js/index.js")}}"></script>
  
  @stop