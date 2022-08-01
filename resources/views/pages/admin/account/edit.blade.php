@extends('layouts.admin')

@section('title')
Account Edit
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Account</h2>
            <p class="dashboard-subtittle">Edit Account</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('account.update', $admin->id) }}"  id="locations" enctype="multipart/form-data" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $admin->email }}" required>
                                @error('email')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                <small class="form-text text-muted">kosongkan jika tidak ingin ganti photo</small>
                                @error('photo')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="province_id">Province</label>
                                <select name="province_id" id="province_id" class="form-control" v-if="provinces" v-model="province_id" required>
                                    <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="city_id">City</label>
                                <select name="city_id" id="city_id" class="form-control" v-if="cities" v-model="city_id" required>
                                    <option v-for="city in cities" :value="city.id">@{{ city.name }}</option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                <small class="form-text text-muted">kosongkan jika tidak ingin ganti password</small>
                                @error('password')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password_confirmation">Password Confimation</label>
                                <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                                <small class="form-text text-muted">kosongkan jika tidak ingin ganti password</small>
                                @error('password_confirmation')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-success px-5 mt-3">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<!-- Axios adalah libary AJAX -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script> 
<script>
    var locations = new Vue({
        el: "#locations", 
        mounted() {
            this.getProvincesData();
        },
        data: {
            provinces: null,
            province_id: null,
            cities: null,
            city_id: null,
        },
        methods: {
           getProvincesData(){
            var self = this;
                axios.get('{{ route('api-provinces') }}') 
                    .then(function(response){
                        self.provinces = response.data;
                    })
           },
           getCityData(){
            var self = this;
                axios.get('{{ url('api/cities') }}/' + self.province_id)
                    .then(function(response){
                        self.cities = response.data;
                    })
           },
        },
        watch: {
            province_id: function(val, oldVal){
                this.city_id = null;
                this.getCityData();
            },
        },
    });
</script>
@endpush