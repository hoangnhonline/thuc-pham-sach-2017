@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="content-page">
    <div class="container">
        <div class="contact-map">
            <img src="{{ URL::asset('public/assets/images/pages/contact-map.jpg') }}" alt="ban do NS" />
        </div>
        <!-- End Map -->        
        <div class="contact-form-page">
            <h2>{{ trans('text.lien-he') }}</h2>
            <div class="form-contact">
                <form>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <input type="text" name="name" value="{{ trans('text.ho-ten') }} *" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue">
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <input type="text" name="email" value="Email *" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue">
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-12">
                            <input type="text" name="title" value="{{ trans('text.tieu-de') }}" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <textarea name="message" cols="30" rows="8" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue"></textarea>
                            <input type="submit" value="{{ trans('text.gui') }}" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection