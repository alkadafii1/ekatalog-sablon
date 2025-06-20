<section class="mt-5">

    <!-- Trigger Modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">
        Delete Account
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="confirmDeleteModalLabel">
                            Confirm Account Deletion
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>
                            Are you sure you want to delete your account? All of your data will be permanently removed.
                        </p>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                            @if ($errors->userDeletion->has('password'))
                                <small class="text-danger">
                                    {{ $errors->userDeletion->first('password') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
