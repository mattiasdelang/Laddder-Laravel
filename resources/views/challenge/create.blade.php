@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')

<div id="createchallenge-page" class="container">
    <div id="pageheader">
        <h1>Create a challenge</h1>
    </div>

    <div class="content">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">

            <div class="col-md-12">
                {!! Form::open(array('url'=>'challenge/create','files'=>true, 'class'=>'form-horizontal')) !!}
                <div class="form-group">
                {!! Form::label('pTitle','What is the title of this challenge?',array('id'=>'','class'=>'col-sm-3 control-label')) !!}
                    <div class="col-sm-5">
                        {!! Form::text('pTitle','',array('id'=>'pTitle','class'=>'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                {!! Form::label('pBanner',"Upload the challenge's banner",array('id'=>'','class'=>'col-sm-3 control-label')) !!}
                    <div class="col-sm-5">
                        {!! Form::file('pBanner', array('id'=>'pBanner','class'=>'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                {!! Form::label('pDescription','Describe the challenge.',array('id'=>'','class'=>'col-sm-3 control-label')) !!}
                    <div class="col-sm-5">
                        {!! Form::textarea('pDescription', null, array('id'=>'','class'=>'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                {!! Form::label('pStart','When should the challenge start?',array('id'=>'','class'=>'col-sm-3 control-label')) !!}
                    <div class="col-sm-5">
                        {!! Form::text('pStart', '', array('id' => 'startDate','class'=>'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                {!! Form::label('pEnd','When should the challenge end?',array('id'=>'','class'=>'col-sm-3 control-label')) !!}
                    <div class="col-sm-5">
                        {!! Form::text('pEnd', '', array('id' => 'endDate','class'=>'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        {!! Form::submit('Save', array('id' => '','class'=>'btn btn-default btnLaddderOrange')) !!}
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>




@endsection

