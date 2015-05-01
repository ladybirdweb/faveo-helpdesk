
{!! Form::open(['url'=>'postcheck/'.$table->agent_id , 'method' => 'post']) !!}
@while (list($key, $val) = each($teams)) 
<input type="checkbox" name="team_id[]" value="<?php echo $val; ?>" <?php if (in_array($val, $assign)) echo( 'checked'); ?> ><?php echo $key; ?><br/>
@endwhile

<input type="submit" value="submit">
{!!Form::close()!!}

