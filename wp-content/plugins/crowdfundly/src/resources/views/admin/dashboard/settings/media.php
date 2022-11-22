<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <layout-settings sub-title="Media">
            <div class="settings__section settings__section--media">
                <div class="settings__section-inner" v-if="loading">
                    <c-loader variant="primary"></c-loader>
                </div>
                <div class="settings__section-inner" v-else>
                    <form action="">
                        <div class="media">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-5 col-xl-4">
                                    <c-input-group label="Logo" label-for="logo">
                                        <image-picker id="logo" media-key="logo" :media-id="media.logo?.id" @file="handleFileUpload" v-model="media.logo"></image-picker>
                                    </c-input-group>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-5 col-xl-4">
                                    <c-input-group label="Footer Logo" label-for="footer-logo">
                                        <image-picker id="footer-logo" media-key="footer_logo" :media-id="media.footer_logo?.id" @file="handleFileUpload" v-model="media.footer_logo"></image-picker>
                                    </c-input-group>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-5 col-xl-4">
                                    <c-input-group label="Favico" label-for="favico">
                                        <image-picker id="favicon" media-key="favicon" :media-id='media.favicon?.id' @file="handleFileUpload" v-model="media.favicon"></image-picker>
                                    </c-input-group>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <c-input-group label="Cover Photo" label-for="cover-photo">
                                        <image-picker id="cover-photo" media-key="cover_photo" @file="handleFileUpload" :media-id="media.cover_photo?.id" v-model="media.cover_photo"></image-picker>
                                    </c-input-group>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <c-input-group label="Sider Images" label-for="slider-images">
                                        <template v-slot:label>
                                            <small class="text-primary">(Max 10 images)</small>
                                            <!-- <br>
                                            <small>You can drag & drop image & video link</small> -->
                                        </template>
                                        <gallery-uploader :gallery="media.gallery"></gallery-uploader>
                                    </c-input-group>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </layout-settings>
    </layout-dashboard>
</div>
<style>
    .gallery-uploader__picker:last-child {
        display: none;
    }
</style>
<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                loading: true,
                media: {
                    cover_photo: null,
                    logo: null,
                    footer_logo: null,
                    favicon: null,
                    gallery: []
                }
            }
        },
        async created() {
            this.loading = true;
            await this.fetch()
        },

        computed: {
            logo() {
                console.log('hi')
            }
        },
        methods: {
            async fetch() {
                await this.$axios.get(`/organization`)
                    .then(res => {
                        this.media = {
                            ...this.media,
                            ...res.data
                        }

                        if (this.media.logo !== null) {
                            this.media.logo.url = this.media.logo.source_path
                        }
                        if (this.media.footer_logo !== null) {
                            this.media.footer_logo.url = this.media.footer_logo.source_path
                        }

                        this.media.favicon ? this.media.favicon.url = this.media.favicon.source_path : false
                        this.media.cover_photo ? this.media.cover_photo.url = this.media.cover_photo.source_path : false
                        this.media.gallery? this.media.gallery.map(item=>{
                            item.url = item.source_path
                            item.type = this.$getMediaType(item.media_type)
                        }) : false
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },

            handleFileUpload(payLoad) {
                console.log('file & media type: ', payLoad)
                let {
                    file,
                    mediaType
                } = payLoad
                switch (mediaType) {
                    case 'logo':
                        this.handleLogoUpload(file)
                        return;

                    case 'footer_logo':
                        this.handleFooteLogoUpload(file)
                        return

                    case 'favicon':
                        this.handleFaviconUpload(file)
                        return

                    case 'cover_photo':
                        this.handleCoverPhotoUpload(file)
                        return
                    default:
                        return
                        break;
                }
            },
            handleLogoUpload(file) {
                let formData = new FormData();
                formData.append('logo', file);
                formData.append('_method', 'PUT')
                
                this.$axios.post('/organization/media', formData)
                    .then((res) => {
                        console.log("logo upload res : ", res)
                        this.fetch()
                    }).catch(err => {
                        console.log(err)
                    })
            },

            handleFooteLogoUpload(file) {
                let formData = new FormData();
                formData.append('footer_logo', file);
                formData.append('_method', 'PUT')

                this.$axios.post('/organization/media', formData)
                    .then((res) => {
                        console.log("footer logo upload res : ", res)
                        this.fetch()
                    }).catch(err => {
                        console.log(err)
                    })
            },

            handleFaviconUpload(file) {
                let formData = new FormData();
                formData.append('favicon', file);
                formData.append('_method', 'PUT')

                this.$axios.post('/organization/media', formData)
                    .then((res) => {
                        console.log("favicon upload res : ", res)
                        this.fetch()
                    }).catch(err => {
                        console.log(err)
                    })
            },
            
            handleCoverPhotoUpload(file){
                let formData = new FormData();
                formData.append('cover_photo', file);
                formData.append('_method', 'PUT')

                this.$axios.post('/organization/media', formData)
                    .then((res) => {
                        console.log("cover upload res : ", res)
                        this.fetch()
                    }).catch(err => {
                        console.log(err)
                    })
            }
        },
    });
</script>