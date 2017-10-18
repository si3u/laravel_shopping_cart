<div class="col-lg-6" style="background: #df5c53;color:#fff;padding: 10px;">
    <form id="form_print_create" class="form-horizontal" action="javascript:void(0);" method="post">
        <input id="form_action" type="hidden" value="{{ route('public.print.create') }}">
        <h4 class="text-center">{{__('print.left.select_size')}}</h4>
        <div class="row">
            <div class="col-xs-12">
            @foreach ($sizes as $size)
                <div class="col-xs-6">
                    <label class="radio-inline">
                        <input  data-width="{{ $size->width }}" data-height="{{ $size->height }}" type="radio" id="size_radio" name="size_radio">
                        {{ $size->width }}x{{ $size->height }}
                    </label>
                </div>
            @endforeach
            </div>
        </div>

        <h4 class="text-center">{{__('print.left.else')}}</h4>

        <div class="form-group">
            <label class="control-label col-md-4" for="width">{{__('print.left.width')}}</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="width" value="0">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4" for="height">{{__('print.left.height')}}</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="height" value="0">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4" for="canvas">{{__('print.left.canvas.lable')}}</label>
            <div class="col-md-8">
                <select class="form-control" id="canvas">
                    <option value="1">{{__('print.left.canvas.op1')}}</option>
                    <option value="0">{{__('print.left.canvas.op2')}}</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4" for="phone">{{__('print.left.tel')}}</label>
            <div class="col-md-8">
                <input id="phone" class="form-control" placeholder="+38(XXX) XXX XX XX">
            </div>
        </div>

        <h6 class="text-center">{{__('print.left.title_input_file')}}</h6>

        <div class="form-group" style="margin: 0px; margin-bottom:10px;">
    		<div class="input-group input-file" name="file">
    			<span class="input-group-btn">
            		<button class="btn btn-default btn-choose" type="button">{{__('print.file.btn_select')}}</button>
        		</span>
        		<input type="text" class="form-control" placeholder="{{__('print.file.input')}}"/>
        		<span class="input-group-btn">
           			 <button class="btn btn-warning btn-reset" type="button">{{__('print.file.btn_reset')}}</button>
        		</span>
    		</div>
    	</div>

        <div class="form-group" style="margin: 0px;">
            <div class="col-md-12">
                @include('includes.alerts.ajax')
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success btn-lg">{{ __('print.btn_submit') }}</button>
            </div>
        </div>
    </form>
</div>
