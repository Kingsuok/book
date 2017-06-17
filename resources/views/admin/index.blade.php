@extends('layouts.master')
@section('title')
    <title>index</title>
@endsection
@section('headAndMenu')
    @parent
@endsection
@section('content')

    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/" class="maincolor">Home</a>
            <td class="c-999 en">&gt;</td>
            <td class="c-666">My Desk</td>
            <a class="btn btn-success radius r" style="trne-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <p class="f-20 text-success">Welcome to Book Admin
                    <td class="f-14">v1.0</td>
                    Management System</p>


                <table class="table table-border table-bordered table-bg mt-20">
                    <thead>
                    <tr>
                        <th colspan="2" scope="col">Server Info</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>OS</td><td>{{PHP_OS}}</td>
                    </tr>
                    <tr>
                        <td>Operating environment</td><td>{{$_SERVER['SERVER_SOFTWARE']}}</td>
                    </tr>
                    <tr>
                        <td>PHP Running Mode</td><td>apache2handler</td>
                    </tr>
                    <tr>
                        <td>Version</td><td>v-1.0</td>
                    </tr>
                    <tr>
                        <td>Upload Restrictions</td><td>{{get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"no upload attachment"}}</td>
                    </tr>
                    <tr>
                        <td>Toroto time</td><td>{{date("Y-m-d G:i:s")}}</td>
                    </tr>
                    <tr>
                        <td>Server Domain Name/IP</td><td>{{$_SERVER['SERVER_NAME']}} [{{$_SERVER['SERVER_ADDR']}}]</td>
                    </tr>
                    <tr>
                        <td>Host</td><td>{{$_SERVER['SERVER_ADDR']}}</td>
                    </tr>
                    </tbody>
                </table>
            </article>
            <footer class="footer">
                <p><br> Copyright &copy; admin v1.0 All Rights Reserved.<br></p>
            </footer>
        </div>
    </section>
@endsection
    @section('my-js')
        <!--请在下方写此页面业务相关的脚本-->
        <script type="text/javascript">

        </script>
        <!--/请在上方写此页面业务相关的脚本-->
    @endsection

