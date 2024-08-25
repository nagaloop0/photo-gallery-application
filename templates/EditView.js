Vue.component("EditView", {
    data() {
        return {

        }
    },
    props: ['data'],
    methods: {

    },
    template: `
        <div class="modal fade" id="editGallery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editGalleryLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="index.php" enctype="multipart/form-data" method="POST">
                        <input type="hidden" name="action" value="create_journal" />
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editGalleryLabel">Create Gallery</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group m-3">
                                <input class="form-control" name="title" placeholder="Enter Gallery Title" />
                            </div>
                            <div class="m-3">
                                <input type="file" name="photo" />
                            </div>
                            <div class="form-group m-3">
                                <textarea class="form-control" rows="4" placeholder="Write your imagination" name="content"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                </div>
            </div>
        </div>

    `
})