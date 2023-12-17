@php
use Illuminate\Support\Str;

$routeName = Route::currentRouteName();
  function routeNameContains($string) {
    return str_contains(Route::currentRouteName(), $string);
  }
@endphp



@extends('layouts/admin')
@section('content')
    <main id="apartment_show">

        <div id="" class="mb-5">
            <div class="card {{ $routeName == 'admin.dashboard' ? 'border-danger' : ''}}">
                <div class="list-group list-group-flush d-flex gap-2 flex-row align-center">
                    <a href="{{route('admin.dashboard')}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('admin.dashboard') ? 'active' : ''}}"><i class="fa-solid fa-house me-2"></i> Dashboard</a>
                    <a href="{{route('admin.apartments.index')}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}"><i class="fa-solid fa-building me-2"></i> I tuoi appartamenti</a>
                    <a href="{{route ('admin.messages.single', $apartment->id)}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('apartments.index') ? 'active' : ''}}"><i class="fa-solid fa-envelope me-2"></i> Messaggi</a>
                    <a href="{{route('admin.sponsorships.show', $apartment->slug)}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('sponsorships.show') ? 'active' : ''}}"><i class="fa-solid fa-chart-line me-2"></i> Sponsor</a>
                    <a href="{{route('admin.apartments.edit' , $apartment->slug)}}" class="py-3 list-group-item list-group-item-action {{ routeNameContains('sponsorships.show') ? 'active' : ''}}"><i class="fa-solid fa-pen me-2"></i> Modifica</a>
                    <a type="button" class="py-3 list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-trash me-2"></i> Elimina</a>                    
                </div>
            </div>
        </div>
      

        {{-- main --}}
        <div class="container _container">

            <div class="left-inner">
                <div class="name-container">
                    <div class="name"><span style="font-weight:bold">Nome:</span> {{Str::limit($apartment->name, 40)}}</div>
                    @if($activeSponsorships > 0)
                    <div class="sponsored">
                        <i class="fa-solid fa-rocket icon"></i>
                        <span>Sponsorizzato</span> 
                    </div>   
                    @else
                    <div class="sponsored">
                        <i class="fa-solid fa-ghost icon"></i>
                        <span>Non sponsorizzato</span> 
                    </div>  
                    @endif
                </div>
    
                    <div class="img_container">
                        <img src="{{asset('storage/' . $apartment->cover_image)}}" alt="Photo">
                    </div>
                
                
                <div class="info-container-left">
                    <div class="listing_title-left st"><strong>Status</strong></div>
                    <div class="is-visible">
                        <i class="{{$apartment->isVisible == 1 ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash'}}"></i>
                        {{$apartment->isVisible == 1 ? "Listato - I clienti potranno vedere e cercare il tuo appartamento." : "Non listato - I clienti non potranno vedere nè trovare il tuo appartamento tra i risultati."}}
                    </div>
                </div>
                
                 <div class="info-container-left">
                     <div class="listing_title-left"><strong>Servizi offerti</strong></div>
                     <div>
                         <ul class="amenities-container">
                             @foreach ($apartment->services as $service)
                                 <li class="border-0"><div class="am"><span class="am-icon">{!!$service->icon !!}</span> {{$service->name}}</div></li>
                             @endforeach
                         </ul>
                     </div>  
                 </div>
            </div>

            <div class="right-inner">

                <div class="listing-container basics">
                    <div class="listing_title"><span style="font-weight:bold">Descrizione:</span></div>
                    <ul>
                        <li>
                            <div class="results description"> {{Str::limit($apartment->description, 600)}}</div>
                        </li>
                        <hr>
                        
                        
                    </ul>

                    <div class="listing_title-right"><i class="fa-solid fa-location-dot"></i> Indirizzo</div>
                    <div class="results mb-3">{{$apartment->address}}</div>

                </div>
                
                <div class="listing-container">
                    <div class="listing_title prop">Stanze</div>
                    <ul class="properties">
                        <li class="results-container">
                            <div class="listing_title-right"><i class="fa-solid fa-arrows-left-right"></i>Metri quadri</div>
                            <div class="results">{{$apartment->sqm}}</div>
                        </li>
                        <li class="results-container">
                            <div class="listing_title-right"><i class="fa-solid fa-door-closed"></i>Stanze</div>
                            <div class="results">{{$apartment->rooms_number}}</div>
                        </li>
                        <li class="results-container">
                            <div class="listing_title-right"><i class="fa-solid fa-bed"></i>Letti</div>
                            <div class="results">{{$apartment->beds_number}}</div>
                            
                        </li>
                        <li class="results-container">
                            <div class="listing_title-right"><i class="fa-solid fa-bath"></i>Bagni</div>
                            <div class="results">{{$apartment->bathrooms_number}}</div>
                            
                        </li>   
                    </ul>
                </div>
            </div>
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="staticBackdropLabel">Elimina appartamento</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Sicuro di voler eliminare {{$apartment->name}}?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                          <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">ELIMINA</button>
                          </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>  
        </div>

    </main>
@endsection

@section('script')

    <script>
        let closeBtn = document.getElementById('sidebar-btn-close');
        let openBtn = document.getElementById('sidebar-btn-open');
        let elementToHide = document.getElementById('admin-sidebar-mobile');
        let elementToShow = document.getElementById('sidebar-btn-open');
    
        closeBtn.addEventListener('click', function() {
            elementToHide.style.display = 'none';
            elementToShow.style.display = 'flex';
        });

        openBtn.addEventListener('click', function() {
            elementToShow.style.setProperty('display', 'none', 'important');
            elementToHide.style.display = 'block';
        });
    
    </script>

@endsection