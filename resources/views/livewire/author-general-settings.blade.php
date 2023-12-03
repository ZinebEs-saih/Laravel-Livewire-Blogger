<div>
    <form action="" wire:submit.prevent="UpdateGeneralSettings()" method="Post">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Blog name</label>
                    <input type="text" class="form-control" placeholder="Entrer blog name" wire:model="blog_name">
                    @error('blog_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Blog Email</label>
                    <input type="text" class="form-control" placeholder="Entrer blog Email" wire:model="blog_email">
                    @error('blog_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Blog phone</label>
                    <input type="text" class="form-control" placeholder="Entrer blog phone"  wire:model="blog_phone" >
                    @error('blog_phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Blog Description</label>
                    <textarea class="form-control" id="" cols="30" rows="10" wire:model="blog_description"></textarea>                     
                </div>
                <button class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </form>
</div>

