@extends('themes.default1.installer.layout.installer')

@section('licence')
done
@stop

@section('environment')
done
@stop

@section('database')
active
@stop

@section('content')

  
        <h1>Page Setup</h1>

        {!! Form::open(['url'=> '/step4post']) !!}
            <table>
                <tr>
                    <td>
                        <label for="selectbox1">Database</label>
                    </td>
                    <td>
                        <select class="form-control" name="default" id="default">
                            <option value="mysql">mysql</option>
                            <option value="pgsql">pgsql</option>
                            <option value="sqlsrv">sqlsrv</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box1">HOST</label>
                    </td>
                    <td>
                        <input type="text" name="host" required>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box2">PORT</label>
                    </td>
                    <td>
                        <input type="text" name="port"> 
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box3">DATABASE NAME</label>
                    </td>
                    <td>
                        <input type="text" name="databasename" required> 
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box4">USER NAME</label>
                    </td>
                    <td>
                        <input type="text" name="username" required> 
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="box5">PASSWORD</label>
                    </td>
                    <td>
                        <input type="text" name="password"> 
                       
                        </a>
                    </td>
                </tr>
            </table>
            <br>
            <p class="wc-setup-actions step">
                <input type="submit" id="submitme" class="button-primary button button-large button-next" value="Continue">
                <a href="step2.html" class="button button-large button-next" style="float: left">Previous</a>
            </p>
        </form>
    </div>
@stop