// this is the main fil
Vue.component("editview", {
    data() {
        return {

        }
    },
    props: ['data'],
    methods: {
        unlinkPhoto(index){
            if(this.data && this.data.photos[index]){
                delete this.data.photos[index];
                this.data.photos = this.data.photos.filter(ele => ele)
            }
        },
        saveChanges() {
            const form = this.$refs.editviewform;
            const params = new FormData(form);
            params.append("api", "edit_journal");
            console.log(form, params?.get("title"))
            const config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            }
            axios.post('index.php', params, config).then(res=>{
                console.log(res.data);
                if(res && res.data.success){
                    alert(res.data.success)
                    this.$emit("close");
                    this.$root.$emit("refresh-journal");
                }else if(res && res.data?.error){
                    alert(res.data.error)
                }
            })
        },
    },
    computed: {
        getTitle(){
            return this.data && this.data.id ? 'Edit: ' + this.data.title : 'Create';
        }
    },
    template: `
    <div>
    <transition name="modal">
        <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">

                        <div class="modal-header">
                            <slot name="header">
                                <div class="align-items-center d-flex justify-content-between mx-3 my-2 w-100">
                                    <h5 class="modal-default-button">Edit: {{getTitle}}</h5>
                                    <button class="btn" @click="$emit('close')">
                                        <span class="material-symbols-outlined"> close </span>
                                    </button>      
                                </div>                     
                            </slot>
                        </div>

                        <div class="modal-body overflow-auto" style="height:76vh;">
                            <slot name="body">
                                <form class="m-3" method="POST" enctype="multipart/form-data" action="index.php" ref="editviewform">
                                    <input ref="journalid" type="hidden" name="id" :value="data.id"> 
                                    <div class="form-group my-3">
                                        <input class="form-control" name="title" placeholder="Enter Gallery Title" v-model="data.title" />
                                    </div>
                                    <div class="form-group my-3 image-container bg-light" style="height: 500px;">
                                        <template v-if="data.photos.length > 0">
                                            <div ref="imageslider" id="imageslider" class="carousel slide w-100">
                                                <div class="carousel-inner">
                                                    <div v-for="(photo,index) in data.photos" key="photo.id" class="carousel-item position-relative p-2 h-100" :class="index ==0 ? 'active': ''">
                                                        <img :src="photo.photo_name" class="p-2 pointer h-100 d-block w-100" :alt="photo.id" style="object-fit:cover; aspect-ratio:1/1;" />
                                                        <button title="Unlink Image" class="border btn btn-light position-absolute shadow" style="bottom: 2rem; left:50%;" @click.prevent="unlinkPhoto(index)"><span class="material-symbols-outlined"> close </span></button>
                                                    </div>
                                                </div>
                                                <button v-if="false" class="carousel-control-prev" type="button" data-bs-target="#imageslider" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button v-if="false" class="carousel-control-next" type="button" data-bs-target="#imageslider" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </template>
                                        <template v-else>   
                                            <input type="file" class="form-control" name="photo">
                                        </template>
                                    </div>
                                    <div class="form-group my-3">
                                    <textarea class="form-control" rows="4" placeholder="Write your imagination"
                                        name="content">{{data.content}}</textarea>
                                    </div>
                                </form>
                            </slot>
                        </div>

                        <div class="modal-footer justify-content-between my-2 mx-3">
                            <slot name="footer">
                                <label class="text-muted">Last modified on: {{data.modifiedtime}}</label>   
                                <button class="modal-default-button btn btn-success" @click="saveChanges()">Save Changes</button>
                            </slot>
                        </div>
                </div>
            </div>
        </div>
    </transition>
    </div>
    `
}
);

document.addEventListener('DOMContentLoaded', () => {
    var app = new Vue({
        el: '#app',
        data() {
            return {
                search: "",
                journals: [],
                editData: {},
                showModal: false,
                isZoomin: false,
                zoomImage: "",
                recordSkeleton: {
                    title: null, content: null, photos: []
                }
            }
        },
        created() {
            // on component is created
            this.$root.$on("refresh-journal", ()=>{
                console.log("Refreshed.....");
                this.getData();
            })
            this.getData();
        },
        mounted() {
            // on component is mounted/DOM loaded
        },
        methods: {
            zoomInOut(image){
                if(!image){
                    this.isZoomin = false;
                    this.zoomImage = "";
                }else{
                    this.isZoomin = true;
                    this.zoomImage = image;
                }
            },
            getData() {
                console.log(this.search);
                axios.get('index.php', {
                        params: {
                            api: 'list_journal',
                            search: this.search
                        }
                    })
                    .then((response) => {
                        console.log(response)
                        if (response.data) {
                            this.journals = response.data;
                        }
                        console.log(this.journals);
                        // handle success
                    })
                    .catch((error) => {
                        // handle error
                        console.log(error);
                    })
            },
            editview(index){
                if(!this.journals[index]){
                    this.editData = this.recordSkeleton;
                }else{
                    this.editData = this.journals[index];
                }

                console.log(this.editData);

                this.showModal = true;
            },
            deleteGallery(id){
                console.log(id)
                if(!id){
                    return false;
                }

                let proceed = window.confirm("Do you want to delete the gallery?");
                console.log(proceed);
                if (proceed) {
                    axios.delete('index.php', {
                        params: {
                            api: 'delete_journal',
                            id: id
                        }
                    })
                        .then((response) => {
                            console.log(response)
                            if (response.data.error) {
                                alert(response.data.error);
                            }else{
                                alert(response.data.success);
                                this.getData();
                            }
                            // handle success
                        })
                        .catch((error) => {
                            // handle error
                            console.log(error);
                        })
                }
            },
            saveGallery() {
                const form = this.$refs.createGalleryForm;
                const params = new FormData(form);
                params.append("api", "edit_journal");
                console.log(form, params?.values())
                axios.post('index.php', params).then(res=>{
                    console.log(res);
                    if(res && res.data && res.data.success){
                        this.$emit("close");
                        alert(res.data.success)
                        this.$root.$emit("refresh-journal");
                    }else if(res && res.data?.error){
                        alert(res.data.error)
                    }else{
                        alert("Failed to create")
                    }
                }).error(e=>{
                    alert("Failed to create")
                    console(e);
                })
            }
        },
    })
});