@extends('layouts.main')

@section('title', 'ArtVitrina | price')

@section('content')
    @include('includes.header')
    <div class="main-content">
            <div class="site-content-inner">
                <div class="container">
                    <div class="row">
                        <div id="primary" class="content-area col-xs-12 col-sm-12 col-md-12 col-lg-8 col-lg-offset-2 has-sidebar-right sf_top_0">
                            <div id="main" class="site-main">
                                <div class="blog-single">
                                    <article class="blog-item">
                                        <div class="blog-content">
                                            <p>{{ __('price.title') }}</p>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">{{ __('price.table.col1') }}</th>
                                                        <th class="text-center">{{ __('price.table.col2') }}</th>
                                                        <th class="text-center">{{ __('price.table.col3') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($prices as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $item['size'] }}</td>
                                                            <td class="text-center">{{ $item['price_artificial'] }}</td>
                                                            <td class="text-center">{{ $item['price_natural'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <p>{{ __('price.body') }}</p>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 hidden-xs sf_calculator">
            <div class="col-lg-2">
                <div class="col-lg-3"><span class="icon-calculator"> </span></div>
                <div class="col-lg-9 sf_span">{{ __('price.calculator_prices.name') }}</div>
            </div>
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-3">{{ __('price.calculator_prices.canvas.name') }}</span></div>
                            <div class="col-lg-9">
                                <select class="form-control change_item" id="canvas">
                                    <option value="0">{{ __('price.calculator_prices.canvas.artificial') }}</option>
                                    <option value="1">{{ __('price.calculator_prices.canvas.natural') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-3">{{ __('price.calculator_prices.width') }}</div>
                            <div class="col-lg-9"><input class="input-control change_item" id="width" value="0"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-3">{{ __('price.calculator_prices.height') }}</div>
                            <div class="col-lg-9"><input class="input-control change_item" id="height" value="0"></div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-3">{{ __('price.calculator_prices.price') }}</div>
                            <div class="col-lg-9" id="result_calculate">0.00 грн</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('my_scripts')
    <script type="text/javascript">
    $(document).ready(function() {
        $('.change_item').change(function() {
            var canvas = $('#canvas').val();
            var width = $('#width').val();
            var height = $('#height').val();
            if (width > 0 && height > 0) {
                $.ajax({
                    url: '/calculate_price',
                    type: "POST",
                    dataType: 'JSON',
                    data: {
                        'canvas': canvas,
                        'width': width,
                        'height': height,
                    },
                    success: function(response) {
                        $('#result_calculate').text(response.result+' грн.')
                    }
                });
            }
        });
    });
    </script>
@endsection
