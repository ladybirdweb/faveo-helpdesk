@extends('themes.default1.installer.layout.installer')

@section('license')
done
@stop

@section('environment')
done
@stop

@section('database')
active
@stop

@section('content')
  
        <h1 style="text-align: center;">Database Setup</h1>

        {!! Form::open(['url'=> '/step4post']) !!}
            <table>
                <tr>
                    <td>
                        <label for="selectbox1">Database <span style="color
                                : red;font-size:12px;">*</span></label>
                    </td>
                   <td>
                        <div class="side-by-side clearfix moveleftthre">
                            <div>
                                <select name="default" data-placeholder="Choose a SQL format..." class="chosen-select" style="width:290px;" tabindex="2">
                                    <option value=""></option>
                                    <option value="mysql">MySQL</option>
                                    <option value="pgsql">PgSQL</option>
                                    <option value="sqlsrv">SQLSRV</option>
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box1">Host<span style="color
                            : red;font-size:12px;">*</span></label>
                    </td>
                    <td>
                        <input type="text" name="host" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box2">Port</label>
                    </td>
                    <td>
                        <input type="text" name="port"> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box3">Database Name<span style="color
                            : red;font-size:12px;">*</span></label>
                    </td>
                    <td>
                        <input type="text" name="databasename" required> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box4">User Name<span style="color
                            : red; font-size: 12px;">*</span></label>
                    </td>
                    <td>
                        <input type="text" name="username" required> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box5">Password</label>
                    </td>
                    <td>
                        <input type="text" name="password"> 
                    </td>
                </tr>
            </table>
            <br>
            <p class="wc-setup-actions step">
                <input type="submit" id="submitme" class="button-primary button button-large button-next" value="Continue">
                <a href="{!! route('prerequisites') !!}" class="button button-large button-next" style="float: left">Previous</a>
            </p>
        </form>
    </div>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
@stop