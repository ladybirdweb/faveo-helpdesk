@extends('themes.default1.installer.layout.installer')

@section('license')
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

        <a class="twitter-share-button" target="_blank" href="https://twitter.com/intent/tweet?text=I just set up a new HELPDESK with @faveohelpdesk www.faveohelpdesk.com">
            <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQ-uhinU3OzXKj9zlFO7dFxHaChqyHPcWWg5nWgMqYt6N5b3knK" style="width: 86px; float: right;">
        </a>

        <h1 style="text-align: center;">{!! Lang::get('lang.your_helpdesk_is_ready') !!}</h1>
<div class="woocommerce-message woocommerce-tracker">
                <p>{!! Lang::get('lang.all_right_sparky_you_have_made_it') !!}</p>

            </div>


        <div class="setup-next-steps">
            <div class="setup-next-steps-first">
                <h2>{!! Lang::get('lang.next_step') !!}</h2>
                <ul>

                    <li class="setup-product"><a class="button button-primary button-large" href="{!! url('auth/login') !!}" style="float: none; text-align: center; font-size: 24px;    padding: 15px;     line-height: 1;">{!! Lang::get('lang.login_to_faveo') !!}</a>
                    </li>
{{--                @if(\Illuminate\Support\Facades\Event::dispatch('helpdesk.apply.whitelabel'))--}}
{{--         <li class="setup-product"><a class="button button-primary button-large" href="{!! url('auth/login') !!}" style="float: none; text-align: center; font-size: 24px;    padding: 15px;     line-height: 1;">{!! Lang::get('lang.login_to_helpdesk') !!}</a>--}}
{{--                    </li>--}}
{{--        @else--}}

{{--          <li class="setup-product"><a class="button button-primary button-large" href="{!! url('auth/login') !!}" style="float: none; text-align: center; font-size: 24px;    padding: 15px;     line-height: 1;">{!! Lang::get('lang.login_to_faveo') !!}</a>--}}
{{--                    </li>--}}
{{--            @endif--}}

                    

                </ul>
            </div>
            <div class="setup-next-steps-last">
                <h2>{!! Lang::get('lang.learn_more') !!}</h2>
                <ul>
                    <li class="video-walkthrough"><a target="_blank" href="https://www.youtube.com/channel/UC-eqh-h241b1janp6sU7Iiw">{!! Lang::get('lang.video_walk_through') !!}</a>
                    </li>
                    <li class="sidekick"><a target="_blank" href="https://www.support.faveohelpdesk.com/knowledgebase">{!! Lang::get('lang.knowledge_base') !!}</a>
                    </li>

                    <li class="newsletter"><a href="mailto:support@ladybirdweb.com">{!! Lang::get('lang.email_support') !!}</a>
                    </li>
                    <br>
                    <br>
                    <br>
                </ul>
            </div>
        </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="{{asset("lb-faveo/js/index.js")}}"></script>
  @stop