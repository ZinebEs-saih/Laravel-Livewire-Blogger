<div>
    <div class="page-header d-print-none mb-2">
        <div class="row align-items-center">
          <div class="col">
            <h2 class="page-title">
              Authors
            </h2>
          </div>
          <!-- Page title actions -->
          <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
              <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user...." wire:model.live="search">
              <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_author_new">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                New author
              </a>
            </div>
          </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                @forelse ($authors as $author)
                    
                
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body p-4 text-center">
                            <span class="avatar avatar-xl mb-3 rounded" style="background-image: url({{$author->picture}})"></span>
                            <h3 class="m-0 mb-1"><a href="#">{{$author->name}}</a></h3>
                            <div class="text-muted">{{$author->email}}</div>
                            <div class="mt-3">
                            <span class="badge bg-purple-lt">{{$author->authorType->name}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="card-btn" wire:click.prevent="editAuthor({{$author}})"><!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3a2 2 0 0 1 2 2l-8 8-2 6 6-2 8-8a2 2 0 0 1 0 -2"></path>
                            </svg>
                          Edit</a>
                        <a href="#" class="card-btn" wire:click.prevent="deleteAuthor({{$author}})"><!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 5l1-1a2 2 0 0 1 3 0l2 2h6a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-9a2 2 0 0 1 -2 -2z"></path>
                            <line x1="9" y1="17" x2="15" y2="17"></line>
                          </svg>
                        Delete</a>
                    </div>
                </div>
                @empty
                    <div class="text-danger">No Author Found!!</div>
                @endforelse
            </div>
            <div class="row mt-4">
              {{ $authors->links('livewire::simple-bootstrap') }}
            </div>

            {{--modal New Author--}}
            <div wire:ignore.self class="modal modal-blur fade" id="add_author_new" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Add Author</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="./" wire:submit.prevent="addAuthor()" method="Post" autocomplete="off" novalidate="">
                            <div class="mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" placeholder="Enter author name" autocomplete="off" wire:model="name">
                              @error('name')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Enter author email" autocomplete="off" wire:model="email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" placeholder="Enter author username" autocomplete="off" wire:model="username">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Author Type</label>
                                <div>
                                  <select class="form-select" wire:model="auhor_type">
                                    <option value="">-- No Select --</option>
                                   @foreach (\App\Models\type::all() as $type)
                                    <option value="{{$type->id}}"> {{$type->name}}</option>
                                   @endforeach                                    
                                  </select>
                                </div>
                                @error('auhor_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>
                              <div class="mb-3">
                                <div class="form-label">Is direct publisher</div>
                                <div>
                                  <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="direct_publisher"  value="0" wire:model="direct_publisher" >
                                    <span class="form-check-label">No</span>
                                  </label>
                                  <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="direct_publisher"  value="1" wire:model="direct_publisher">
                                    <span class="form-check-label">Yes</span>
                                  </label>
                                </div>
                                @error('direct_publisher')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                        </form>
                    </div>
                    
                  </div>
                </div>
            </div>
          </div>
    </div>

    {{--Modal edit Author--}}
    <div wire:ignore.self class="modal modal-blur fade" id="edit_author" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">editAuthor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="./" wire:submit.prevent="updateAuthor()" method="Post" autocomplete="off" novalidate="">
                <input type="hidden" wire:model='selected_author_id' >
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="Enter author name" autocomplete="off" wire:model="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" placeholder="Enter author email" autocomplete="off" wire:model="email">
                      @error('email')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" class="form-control" placeholder="Enter author username" autocomplete="off" wire:model="username">
                      @error('username')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Author Type</label>
                      <div>
                        <select class="form-select" wire:model="auhor_type">
                         @foreach (\App\Models\type::all() as $type)
                          <option value="{{$type->id}}"> {{$type->name}}</option>
                         @endforeach                                    
                        </select>
                      </div>
                      @error('auhor_type')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <div class="form-label">Is direct publisher</div>
                      <div>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="direct_publisher"  value="0" wire:model="direct_publisher" >
                          <span class="form-check-label">No</span>
                        </label>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="direct_publisher"  value="1" wire:model="direct_publisher">
                          <span class="form-check-label">Yes</span>
                        </label>
                      </div>
                      @error('direct_publisher')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                    </div>
                    <div class="mb-3">
                      <div class="form-label">Blocked</div>
                      <label class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"  wire:model='blocked'>
                        <span class="form-check-label"></span>
                      </label>
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
              </form>
          </div>
          
        </div>
      </div>
  </div>



</div>
