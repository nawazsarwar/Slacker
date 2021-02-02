@extends("layouts.app")
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Channel</div>

                <div class="card-body">
                    <form class="form" action="{{route('slacker.channel.store')}}" method="post">
                        @csrf

                        <div class="form-group row">


                            <div class="col-12">
                                <label for="">Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Den's Project" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label for="">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="Slack Log">Slack Log</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for=""></label>
                            <div class="col-6">
                                <input class="btn btn-danger btn-sm" type="submit" value="Save" name="Save">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
