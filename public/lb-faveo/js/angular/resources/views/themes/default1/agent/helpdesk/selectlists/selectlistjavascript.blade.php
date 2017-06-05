<script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" type="text/javascript"></script>
<script type="text/javascript">
    @if(isset($inputs))
    var request = JSON.parse('<?= json_encode($inputs["show"])?>');
	@else
    var request = ['none'];
    @endif
    $.fn.addSelectlist = function(options) {
        var settings = $.extend({
            // These are the defaults.
            maximumSelectionLength: 1,
        }, options );

		var ajaxurl = '';
		var no_result= '';
		var searching = "{{Lang::get('lang.searching')}}";

        switch(this.attr('id')) {
        	case 'departments-filter':
        		ajaxurl = "{{URL::route('api-get-department-names')}}";
        		no_result = "{{Lang::get('lang.no-department-found')}}";
        		id = '#departments-filter';
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'sla-filter':
        		id = '#sla-filter';
        		ajaxurl = "{{URL::route('api-get-sla-plans')}}";
        		no_result = "{{Lang::get('lang.no-sla-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'priority-filter':
        		id = '#priority-filter';
        		ajaxurl = "{{URL::route('api-get-priorities')}}";
        		no_result = "{{Lang::get('lang.no-priority-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'source-filter':
        		id = '#source-filter';
        		ajaxurl = "{{URL::route('api-get-sources')}}";
        		no_result = "{{Lang::get('lang.no-source-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'owner-filter':
        		id = '#owner-filter';
        		ajaxurl = "{{URL::route('api-get-owners')}}";
        		no_result = "{{Lang::get('lang.no-owner-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'status-filter':
        		id = '#status-filter';
        		ajaxurl = "{{URL::route('api-get-status')}}";
        		no_result = "{{Lang::get('lang.no-status-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'assigned-to-filter':
        		id = '#assigned-to-filter';
        		ajaxurl = "{{URL::route('api-get-assignees')}}";
        		no_result = "{{Lang::get('lang.no-assignee-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'labels-filter':
        		id = '#labels-filter';
        		ajaxurl = "{{URL::route('api-get-lables')}}";
        		no_result = "{{Lang::get('lang.no-labels-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'tags-filter':
        		id = '#tags-filter';
        		ajaxurl = "{{URL::route('api-get-tags')}}";
        		no_result = "{{Lang::get('lang.no-tags-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
        	case 'type-filter':
        		id = '#type-filter';
        		ajaxurl = "{{URL::route('api-get-types')}}";
        		no_result = "{{Lang::get('lang.no-type-found')}}";
        		return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
        		break;
            case 'ticket-number':
                id = '#ticket-number';
                ajaxurl = "{{URL::route('api-get-ticket-number')}}";
                no_result = "{{Lang::get('lang.no-ticket-found')}}";
                return toAddSelect(id, ajaxurl, no_result, searching, settings.maximumSelectionLength);
                break;
        }
     
    };

    function toAddSelect(id, ajaxurl, no_result, searching, max) {
    	$element = $(id).select2({
            minimumInputLength: 2,
            allowClear: true,
            maximumSelectionLength: max,
     	    "language": {
       			    "noResults": function(){
           			    return no_result;
                    },
                    searching: function() {
                       return searching;
                    },
                    inputTooShort: function(args) {
                       // args.minimum is the minimum required length
                       // args.input is the user-typed text
                       var remaining = args.minimum - args.input.length;
                       return "{{Lang::get('lang.please-enter')}} "+remaining+" {{Lang::get('lang.or-more-character')}}";
                    },
                    maximumSelected: function (args) {
                        var message = '{{Lang::get("lang.you-can-only-select")}}' + args.maximum + ' {{Lang::get("lang.item")}}';
                        if (args.maximum != 1) {
                            message += '{{Lang::get("lang.s")}}';
                        }
                        return message;
                    },
                },
                ajax: {
                    url: ajaxurl,
                    dataType: 'json',
                    delay: 250,
                    type: "GET",
                    quietMillis: 50,
                    data: function (params) {
                        return {
                            name: params.term, // search term
                            page: params.page,
                            showing: request[0]
                        };
                    },
                    processResults: function (data) {
                        var selected_values = getSelectedValues(id);
                        var ret= data;
                        var arr = [];
                        if(selected_values != null) {
                            ret = [];
                            for (var d = 0; d < data.length; d++) {
                                if(selected_values.indexOf(data[d].id) == -1) {
                                    ret.push(data[d]);
                                }
                            }
                        }
                        return {
                            results: ret
                        };
                    },
                    cache: true
                },
                templateResult: formatResults,
                templateSelection: formatRepoSelection,
                escapeMarkup: function(m) {
                    return m;
                }
        });
        $('.select2-selection').css('border-radius','0px');
        // $('.select2-selection').css('height','33px');
        $('.select2-container').children().css('border-radius','0px');
        return $element;
    }

    function formatResults(data) {
        var markup = "";
        if(data.details) {
            markup += data.details;
        } else {
            markup += data.text;
        }
        return markup;
    }

    function formatRepoSelection(data) {
        return data.text;
    }

    function getSelectedValues(id) {
        return $(id).val();
    }
</script>