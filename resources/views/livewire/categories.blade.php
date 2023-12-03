<div>
    <div class="row mt-3 ">
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <h4>Categories</h4>
                    <li class="nav-item ms-auto" >
                      <a href="" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCategory">Add Category</a>
                    </li>   
                  </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <thead>
                            <tr>
                              <th>Category name</th>
                              <th>N . of SubCategory</th>
                              <th class="w-1"></th>
                            </tr>
                          </thead>
                          <tbody id="sortable_category">
                            @forelse ($categories as $cotegory)
                            <tr data-index="{{$cotegory->id}}" ordering="{{$cotegory->ordering}}">
                              <td>{{$cotegory->category_name}}</td>
                              <td class="text-muted">
                              {{$cotegory->subcategories->count()}}
                              </td>
                              <td class="btn-group">
                                <a href="#" class="btn btn-sm btn-primary" wire:click.prevent="editCategory({{$cotegory->id}})">Edit</a>&nbsp;
                                <a href="#" class="btn btn-sm btn-danger" wire:click.prevent="deleteCategory({{$cotegory->id}})">Delete</a>
                              </td>
                            </tr>
                                
                            @empty
                            <tr>
                              <td colspan="3">
                                <span class="text-danger">No Category found .</span>
                              </td>
                            </tr>
                      
                                
                            @endforelse
                            
                          </tbody>
                        </table>
                    </div>     
                </div>
              </div>
        </div>
    
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <h4>Subcategoreis</h4>
                    <li class="nav-item ms-auto" >
                      <a href="#tabs-home-1" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#modalSubCategorie">Add SubCategory</a>
                    </li>   
                  </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <thead>
                            <tr>
                              <th>SubCategory name</th>
                              <th>Parent Category</th>
                              <th>N . of Post</th>
                              <th class="w-1"></th>
                            </tr>
                          </thead>
                          <tbody  id="sortable_Subcategory">
                            @forelse ($subCategories as $subcategory)
                            <tr data-index="{{$subcategory->id}}" ordering="{{$subcategory->ordering}}">
                              <td class="text_muted">{{$subcategory->subcategorie_name}}</td>

                              <td>
                                {{ $subcategory->parentcategory  ? $subcategory->parentcategory->category_name : ' - ' }}
                            </td>
                              <td class="text-muted">
                                  {{$subcategory->posts->count()}}
                              </td>
                              <td class="btn-group">
                                <a href="#" class="btn btn-sm btn-primary" wire:click.prevent="editSubCategory({{$subcategory->id}})">Edit</a>&nbsp;
                                <a href="#" class="btn btn-sm btn-danger" wire:click.prevent="deleteSubCategory({{$subcategory->id}})">Delete</a>
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="3">
                                <span class="text-danger">No SubCategory found .</span>
                              </td>
                            </tr>      
                            @endforelse
                          </tbody>
                        </table>
                    </div>     
                </div>
            </div>
        </div>
      </div>
      <!--Modal Category-->
      <div wire:ignore.self  class="modal modal-blur fade" id="modalCategory" tabindex="-1" role="dialog" aria-hidden="true" 
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form class="modal-content" method="POST"  @if ($updateCategoryMode)
          wire:submit.prevent="updateCategory"
        @else
          wire:submit.prevent="addCategory"
        @endif>
            <div class="modal-header">
              <h5 class="modal-title">{{$updateCategoryMode ? 'Update Category' : 'Add Category'}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @if ($updateCategoryMode)
                  <input type="hidden" wire:model="selected_category_id">
              @endif
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" class="form-control" name="" placeholder="Enter Category name" wire:model="category_name">
                    @error('category_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >{{$updateCategoryMode ? 'Update' : 'Save'}} </button>
            </div>
          </form>
        </div>
      </div>
        <div wire:ignore.self  class="modal modal-blur fade" id="modalSubCategorie" tabindex="-1" role="dialog" aria-hidden="true" 
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <form class="modal-content" method="POST"  @if ($updateSubCategoryMode)
              wire:submit.prevent="updateSubCategory"
            @else
              wire:submit.prevent="addSubCategory"
            @endif>
           
            <div class="modal-header">
              <h5 class="modal-title">{{$updateSubCategoryMode ? 'Update SubCategory' : 'Add SubCategory'}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @if ($updateSubCategoryMode)
              <input type="hidden" wire:model="selected_Subcategory_id">
              @endif
              <div class="mb-3">
                <div class="form-label">Parent Category</div>
                <select class="form-select" wire:model="parent_categorie">
                  @if ($updateSubCategoryMode==false)
                      <option value=0>-- Uncategorized --</option>
                  @endif
                  @foreach (\App\Models\Category::all() as $category)
                      <option value="{{$category->id}}">{{$category->category_name}}</option>
                  @endforeach
                </select>
                @error('parent_categorie')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="mb-3">
                <label class="form-label">SubCategory Name</label>
                <input type="text" class="form-control" name="" placeholder="Enter SubCategory name" wire:model="subcategorie_name">
                @error('subcategorie_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
           
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >{{$updateSubCategoryMode ? 'Update' : 'Save'}} </button>
            </div>
          </form>
        </div>
      </div>
      
</div>
