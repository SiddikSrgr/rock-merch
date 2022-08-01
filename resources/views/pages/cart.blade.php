@extends('layouts.app')

@section('title')
Cart
@endsection

@section('content')
      <div class="container" data-aos="fade-down">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
          </ol>
        </nav>
      </div>

      <div class="container" data-aos="fade-down">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Weight</th>
                        <th scope="col">Size</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    @php $sub_total = 0 @endphp 

                    @forelse($carts as $cart)
                      <tr>
                        <td>
                            <a href="/detail/{{$cart->product->slug}}">
                                <img src="{{ asset('storage/'.$cart->product->galleries->first()->photo) }}" style="width: 100px; height:100px" alt="">
                            </a>
                        </td>
                        <td class="cart-detail">{{ $cart->product->name }}</td>
                        <td class="cart-detail">IDR {{ number_format($cart->product->price) }}</td>
                        <td class="cart-detail">{{ $cart->product->weight }} gr</td>
                        <td class="cart-detail">{{ $cart->size->name }}</td>
                        <td class="cart-detail">{{ $cart->qty }}
                            <small class="text-muted">(tersedia {{$cart->product->stocks->first()->stock}})</small>
                        </td>
                        <td class="cart-detail">IDR {{ number_format($cart->product->price * $cart->qty) }}</td>
                        <td class="cart-detail">
                            <form action="/cart/delete/{{$cart->id}}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete this cart?')">Remove</button>
                            </form>
                        </td> 
                      </tr>

                    @php $sub_total += ($cart->product->price * $cart->qty) @endphp

                    @empty
                    <tr><td colspan="8" class="text-center text-danger">No Carts Found</td></tr>
                    @endforelse
                    
                    </tbody>
                </table> 
            </div>
        </div>
      </div>

    <div class="container mt-4" data-aos="fade-up">
        <hr>
    </div>

    <div class="container mt-4" data-aos="fade-up">
        @php $city = \App\Models\City::find($admin->city_id); @endphp
        <h6>Shipping Details <span class="text-secondary">(Shipping From {{$city->name}})</span></h6>
    </div>

    <form action="/checkout" method="post" id="locations"  enctype="multipart/form-data">
    @csrf
    <!-- input type hidden digunakan untuk mengambil value sub_total -->
    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
      <div class="container mt-3"  data-aos="fade-up" id="locations">
        <div class="row">
                <div class="col-lg-12">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="province_destination_id">Provinsi Tujuan</label>
                                <select name="province_destination_id" id="province_destination_id" class="form-control" v-if="provinces_destination" v-model="province_destination_id" required>
                                    <option v-for="province in provinces_destination" :value="province.id">@{{ province.name }}</option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="city_destination_id">Kota/Kabupaten Tujuan</label>
                                <select name="city_destination_id" id="city_destination_id" class="form-control" v-if="cities_destination" v-model="city_destination_id" required>
                                    <option v-for="city in cities_destination" :value="city.id">@{{ city.name }}</option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address">Alamat Lengkap</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="postal_code">Kode Pos</label>
                                <input type="number" class="form-control" id="postal_code" name="postal_code" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mobile">Nomor Handphone</label>
                                <input type="number" class="form-control" id="mobile" name="mobile" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="weight">Berat (gram)</label>
                                <input type="number" class="form-control" id="weight" name="weight" v-model="weight" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="courier">Kurir</label>
                                <select class="form-control" name="courier" @change="getCostOngkir" v-model="courier" required>
                                    <option value="jne">JNE</option>
                                    <option value="pos">POS</option>
                                    <option value="tiki">TIKI</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                            <label for="ongkir">Biaya Ongkir</label>
                                <select name="ongkir" id="ongkir" class="form-control" v-model="ongkir" required>
                                    <option  v-if="ongkirList" v-for="ongkir in ongkirList" :value="ongkir.cost[0].value">@{{ ongkir.service }} - @{{ ongkir.cost[0].value }} - @{{ ongkir.cost[0].etd }} Hari</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>

      <div class="container">
        <hr>
      </div>

      <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-3">
                        <h5 class="text-dark">IDR {{ number_format($sub_total) }}</h5>
                        <p class="text-muted">Sub Total</p>
                    </div>
                    <div class="col-lg-3">
                        <h5 class="text-dark" v-bind:value="ongkir">IDR @{{ Number(ongkir).toLocaleString() }}</h5>
                        <p class="text-muted">Shipping Cost</p>
                    </div>
                    <div class="col-lg-3">
                        <!-- input type hidden digunakan untuk mengambil value grand_total -->
                        <input type="hidden" name="grand_total" v-bind:value="subTotal + ongkir">
                        <h5 class="text-success">IDR @{{ Number(subTotal + ongkir).toLocaleString() }}</h5>
                        <p class="text-muted">Grand Total</p>
                    </div>
                    <div class="col-lg-3">
                        @if(count($carts) > 0)
                        <button type="submit" class="btn btn-success px-4 py-3">Checkout Now</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
      </div>
</form>
@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<!-- Axios adalah libary AJAX -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script> 
<script>
    var locations = new Vue({
        el: "#locations", 
        mounted() {
            AOS.init();
            this.getProvincesData();
        },
        data: {
            provinces_destination: null,
            cities_destination: null,
            
            city_origin_id: {{ $admin->city_id }}, 

            province_destination_id: null,
            city_destination_id: null,

            weight: {{ $weightTotal }},
            courier: null,

            ongkirList: null,
            ongkir: null,

            subTotal: {{ $sub_total }},
        },
        methods: {
           getProvincesData(){
            var self = this;
                axios.get('api/provinces/') 
                    .then(function(response){
                        self.provinces_destination = response.data;
                    })
           },
           getCityOriginData(){
            var self = this;
                axios.get('api/cities/' + self.province_origin_id)
                    .then(function(response){
                        self.cities_origin = response.data;
                    })
           },
           getCityDestinationData(){
            var self = this;
                axios.get('api/cities/' + self.province_destination_id)
                    .then(function(response){
                        self.cities_destination = response.data;
                    })
           },
           getCostOngkir(){
            var self = this;
            axios.post('api/checkOngkir/', {
                origin: self.city_origin_id,
                destination: self.city_destination_id,
                weight: self.weight,
                courier: self.courier
                })
                .then(function (response) {
                    self.ongkirList = response.data.data[0].costs
                }).catch(error => {
                    this.response = 'Error: ' + error.response.status
                })
           },
        },
        watch: {
            province_origin_id: function(val, oldVal){
                this.city_origin_id = null;
                this.getCityOriginData();
            },
            province_destination_id: function(val, oldVal){
                this.city_destination_id = null;
                this.getCityDestinationData();
            },
            courier: function(val, oldVal){
                this.ongkirList = null;
                this.getCostOngkir();
            }
        },
    });
</script>
@endpush