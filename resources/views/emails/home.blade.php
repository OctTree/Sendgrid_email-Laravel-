@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">{{ __('Mail Send') }}</div>
                @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="row">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-md-8">
                                            <form method="POST" action="{{ url('send/email') }}">
                                                @csrf

                                                <div class="form-group row">
                                                    <label for="email_from" class="col-md-4 col-form-label text-md-right">{{ __('From') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="email_from" type="email" class="form-control" name="email_from" value="{{  Auth::user()->email }}" required disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="email_to" class="col-md-4 col-form-label text-md-right">{{ __('To') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="email_to" type="email" class="form-control @error('email_to') is-invalid @enderror" name="email_to" value="{{ old('email') }}" required autocomplete="email">

                                                        @error('email_to')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Subject') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" required autocomplete="new-subject">

                                                        @error('subject')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="email_content" class="col-md-4 col-form-label text-md-right">{{ __('Email Content') }}</label>

                                                    <div class="col-md-6">
                                                        <textarea id="email_content" type="text" class="form-control @error('email_content') is-invalid @enderror" name="email_content" required autocomplete="email_content"></textarea>

                                                        @error('email_content')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-primary" style="width:120px;">
                                                            {{ __('SEND') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="container">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="2"><h2>Analysis</h2></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Number of sent</td>
                                                        <td><?php echo $rate[0]['sent'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rate of bounced</td>
                                                        <td><?php echo $rate[1]['bounced'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rate of delivered</td>
                                                        <td><?php echo $rate[2]['delivered'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Opening rate</td>
                                                        <td><?php echo $rate[3]['opened'];?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                </div>
                            </div>
                </div>
            </div>
            <div class="card">
                @if($log_lists = Session::get('log_lists'))
                <div class="table-responsive">
                    <table class="table table-bordered" style="text-align:center;">
                            <thead>
                                <tr>
                                    <th style="width:1%">No</th>
                                    <th style="width:10%">From</th>
                                    <th style="width:10%">To</th>
                                    <th style="width:9%">Subject</th>
                                    <th style="width:50%">message</th>
                                    <th style="width:20%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; foreach ($log_lists as $log_list) { ?>
                                <tr>
                                    <td><?php echo ++$i;?></td>
                                    <td><?php echo $log_list->s_email;?></td>
                                    <td><?php echo $log_list->r_email;?></td>
                                    <td><?php echo $log_list->subject;?></td>
                                    <td><?php echo $log_list->message;?></td>
                                    <?php if($log_list->status == 'B'){ ?>
                                        <td><span class="badge badge-dark" style="width:60px;">Bounced</span></td>
                                    <?php };?>
                                    <?php if($log_list->status == 'D'){ ?>
                                        <td><span class="badge badge-danger" style="width:60px;">Delivered</span></td>
                                    <?php };?>
                                    <?php if($log_list->status == 'O'){ ?>
                                        <td><span class="badge badge-success" style="width:60px;">Open</span></td>
                                    <?php };?>
                                    <?php if($log_list->status == 'C'){ ?>
                                        <td><span class="badge badge-info" style="width:60px;">Clicked</span></td>
                                    <?php };?>
                                </tr>
                            <?php } ?>
                            </tbody>
                    </table>
                </div>
                @else
                <div class="">
                    <table class="table table-bordered table-responsive" style="text-align:center; width:100%;">
                            <thead>
                                <tr>
                                    <th style="width:1%">No</th>
                                    <th style="width:10%">From</th>
                                    <th style="width:10%">To</th>
                                    <th style="width:9%">Subject</th>
                                    <th style="width:50%">message</th>
                                    <th style="width:20%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; foreach ($current_lists as $current_list) { ?>
                                <tr>

                                    <td><?php echo ++$i;?></td>
                                    <td><?php echo $current_list->s_email;?></td>
                                    <td><?php echo $current_list->r_email;?></td>
                                    <td><?php echo $current_list->subject;?></td>
                                    <td><?php echo $current_list->message;?></td>
                                    <?php if($current_list->status == 'B'){ ?>
                                        <td><span class="badge badge-dark" style="width:60px;">Bounced</span></td>
                                    <?php };?>
                                    <?php if($current_list->status == 'D'){ ?>
                                        <td><span class="badge badge-danger" style="width:60px;">Delivered</span></td>
                                    <?php };?>
                                    <?php if($current_list->status == 'O'){ ?>
                                        <td><span class="badge badge-success" style="width:60px;">Open</span></td>
                                    <?php };?>
                                    <?php if($current_list->status == 'C'){ ?>
                                        <td><span class="badge badge-info" style="width:60px;">Clicked</span></td>
                                    <?php };?>
                                </tr>
                            <?php } ?>
                            </tbody>
                    </table>
                </div>
                @endif


            </div>
        </div>
    </div>
</div>
@endsection
