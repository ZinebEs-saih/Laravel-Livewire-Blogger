<div>
    <form action="" wire:submit.prevent="UpdateBlogSocialMedia()"  method="Post">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Facebook</label>
                    <input type="text" class="form-control" placeholder="Facebook page Url" wire:model="bsm_facebook">
                    @error('bsm_facebook')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Instagram</label>
                    <input type="text" class="form-control" placeholder="Instagram Url" wire:model="bsm_instagram">
                    @error('bsm_instagram')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Youtube</label>
                    <input type="text" class="form-control" placeholder="Youtube Channel Url" wire:model="bsm_youtube" >
                    @error('bsm_youtube')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                  <label for="" class="form-label">LinkedIn</label>
                  <input type="text" class="form-control" placeholder="Linkedin Url" wire:model="bsm_linkedin" >
                  @error('bsm_linkedin')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
          </div>
            </div>
            <button class="btn btn-primary">Update</button>

        </div>
    </form>
</div>
