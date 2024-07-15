<template>
    <section id="basicInformationView">
        <h5 class="custom_dark mb-3">Informações básicas</h5>

        <form class="container-fluid shadow rounded-2 mb-5">
            <div class="row p-3">
                <p class="custom_dark fs-7" >Informações básicas do site</p>
                <hr class="custom-hr-dark">

                <div class="container mt-3 mb-4">
                    <div class="row mb-5">
                        <!-- Logo image -->
                        <div class="col-sm-12 col-lg-4 previewImg mb-4">
                            <img :src="previewImages.previewLogo ? previewImages.previewLogo : defaultImages.defaultLogoImage" alt="Logotipo">
                        </div>
                        <div class="col-sm-12 col-lg-8">
                            <p class="custom_dark">Escolha a imagem do seu logotipo</p>
                            <p class="custom_dark opacity-75 fs-8">Recomenda-se dimensão de 250px por 125px, tamanho máximo 5 MB, (JPG, JPEG ou PNG.)</p>

                            <div v-if="previewImages.previewLogo" class="d-flex gap-2 align-items-center">
                                <button @click="cancelSetImg('logoImage')" type="button" class="btn btn-sm btn-danger">Cancelar</button>
                                <span>{{ images.logoImage.name }}</span>
                            </div>
                        
                            <input v-else @change="setImage($event, 'logoImage')" class="form-control custom_focus form-control-sm" type="file" :accept="acceptImg">
                            
                        </div>
                    </div>

                    <div class="row mb-5">
                        <!-- Cover image -->
                        <div class="col-sm-12 col-lg-4 previewImg mb-4">
                            <img :src="previewImages.previewCoverImg ? previewImages.previewCoverImg : defaultImages.defaultCoverImage" alt="Logotipo">
                        </div>
                        <div class="col-sm-12 col-lg-8">
                            <p class="custom_dark">Escolha a imagem de capa</p>
                            <p class="custom_dark opacity-75 fs-8">tamanho máximo 5 MB, (JPG, JPEG ou PNG.)</p>

                            <div v-if="previewImages.previewCoverImg" class="d-flex gap-2 align-items-center">
                                <button @click="cancelSetImg('coverImage')" type="button" class="btn btn-sm btn-danger">Cancelar</button>
                                <span>{{ images.coverImage.name }}</span>
                            </div>
                        
                            <input v-else @change="setImage($event, 'coverImage')" class="form-control custom_focus form-control-sm" type="file" :accept="acceptImg">
                            
                        </div>
                    </div>

                    <div class="row mb-5">
                        <!-- icon image -->
                        <div class="col-sm-12 col-lg-4 preview-ico mb-4">
                            <img :src="previewImages.previewIco ? previewImages.previewIco : defaultImages.defaultIcon" alt="Logotipo">
                        </div>
                        <div class="col-sm-12 col-lg-8">
                            <p class="custom_dark">Escolha um favicon para o seu site</p>
                            <p class="custom_dark opacity-75 fs-8">Favicons são pequenas imagens de 16 x 16 pixels associadas a um site, geralmente mostradas na barra de endereços do navegador e na lista de favoritos.</p>

                            <div v-if="previewImages.previewIco" class="d-flex gap-2 align-items-center">
                                <button @click="cancelSetImg('icon')" type="button" class="btn btn-sm btn-danger">Cancelar</button>
                                <span>{{ images.ico.name }}</span>
                            </div>
                        
                            <input v-else @change="setImage($event, 'icon')" class="form-control custom_focus form-control-sm" type="file" :accept="acceptIcon">
                            
                        </div>
                    </div>
                    
                    <div class="row mb-5">
                        <!-- Default image -->
                        <div class="col-sm-12 col-lg-4 previewImg mb-4">
                            <img :src="previewImages.previewDefaultImg ? previewImages.previewDefaultImg : defaultImages.defaultImage" alt="Logotipo">
                        </div>
                        <div class="col-sm-12 col-lg-8">
                            <p class="custom_dark">Escolha a imagem padrão</p>
                            <p class="custom_dark opacity-75 fs-8">tamanho máximo 5 MB, (JPG, JPEG ou PNG.)</p>

                            <div v-if="previewImages.previewDefaultImg" class="d-flex gap-2 align-items-center">
                                <button @click="cancelSetImg('defaultImage')" type="button" class="btn btn-sm btn-danger">Cancelar</button>
                                <span>{{ images.defaultImage.name }}</span>
                            </div>
                        
                            <input v-else @change="setImage($event, 'defaultImage')" class="form-control custom_focus form-control-sm" type="file" :accept="acceptImg">
                            
                        </div>
                    </div>

                    <div v-if="updatedFiles()" class="mb-3 alerta-cache">
                        <p class="m-0" >Pode ser necessário <span class="fw-medium cursor_pointer">recarregar a página</span> ou até limpar o cache do navegador para visualizar as alterações nas imagens.</p>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button @click="submitImages()" type="button" class="btn btn-sm btn-primary" :disabled="loadingSaveImgs || !updatedFiles()">
                            <template v-if="!loadingSaveImgs">
                                Salvar Alterações
                            </template>
                            <template v-else>
                                <AppSpinnerLoading message="Aguarde..." color="text-white" />
                            </template>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
import AppSpinnerLoading from '@/components/shared/AppSpinnerLoading.vue';
import { siteInfoStore } from '@/store/siteInfoStore';
import defaultLogo from '@/assets/img/default/defaultLogo.png';
import defaultCoverImage from '@/assets/img/default/defaultCoverImage.png';
import defaultIcon from '@/assets/img/default/icon.png';
import defaultImage from '@/assets/img/default/defaultImage.png';
import FileValidator from '@/validators/FileValidator';
import SiteInfoService from '@/services/SiteInfoService';
import { alertStore } from '@/store/alertStore';
import MetaManager from '@/helpers/MetaManager';

export default {
    name: 'BasicInformationView',
    components: {
        AppSpinnerLoading
    },

    data() {
        return {
            acceptImg: "image/jpeg, image/jpg, image/png",
            acceptIcon: "image/vnd.microsoft.icon, image/x-icon, image/jpeg, image/jpg, image/png",
            previewImages: {
                previewLogo: "",
                previewCoverImg: "",
                previewIco: "",
                previewDefaultImg: ""
            },
            defaultImages: {
                defaultLogoImage: siteInfoStore.constants.logoImage ? `${this.$API_URL}/uploads/systemImages/${siteInfoStore.constants.logoImage}` : defaultLogo,
                defaultCoverImage: siteInfoStore.constants.coverImage ? `${this.$API_URL}/uploads/systemImages/${siteInfoStore.constants.coverImage}` : defaultCoverImage,
                defaultIcon: siteInfoStore.constants.ico ? `${this.$API_URL}/uploads/systemImages/${siteInfoStore.constants.ico}` : defaultIcon,
                defaultImage: siteInfoStore.constants.defaultImage ? `${this.$API_URL}/uploads/systemImages/${siteInfoStore.constants.defaultImage}` : defaultImage,
            },
            images: {
                logoImage: null,
                coverImage: null,
                ico: null,
                defaultImage: null
            },
            loadingSaveImgs: false,
        }
    },

    methods: {
        setImage(event, image) {
            const fileInput = event.target;
            const file = fileInput.files?.[0];

            let previewImage = "";
            let fileToSave = null;

            switch (image) {
                case "logoImage":
                    previewImage = "previewLogo";
                    fileToSave = "logoImage";
                    break;
                case "coverImage":
                    previewImage = "previewCoverImg";
                    fileToSave = "coverImage";
                    break; 
                case "icon":
                    previewImage = "previewIco";
                    fileToSave = "ico";
                    break;  
                case "defaultImage":
                    previewImage = "previewDefaultImg";
                    fileToSave = "defaultImage";
                    break;   
                default:
                    return;
            }
            
            if(file) {

                let fileValid = false;

                if(image === "icon") {
                    fileValid = FileValidator.validIcon(file);
                } else {
                    fileValid = FileValidator.validImage(file)
                }

                if(fileValid) {
                    this.images[fileToSave] = file;
                    const reader = new FileReader();

                    reader.onload = () => {
                        this.previewImages[previewImage] = reader.result?.toString();
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileInput.value = '';
                }
            }
        },

        cancelSetImg(image) {
            let previewImage = "";
            let fileToSave = null;

            switch (image) {
                case "logoImage":
                    previewImage = "previewLogo";
                    fileToSave = "logoImage";
                    break;
                case "coverImage":
                    previewImage = "previewCoverImg";
                    fileToSave = "coverImage";
                    break;
                case "icon":
                    previewImage = "previewIco";
                    fileToSave = "ico";
                    break;  
                case "defaultImage":
                    previewImage = "previewDefaultImg";
                    fileToSave = "defaultImage"; 
                    break;   
                default:
                    return;
            }

            this.previewImages[previewImage] = "";
            this.images[fileToSave]  = null;
        },

        updatedFiles() {
            for(let img in this.images) {
                if(this.images[img]) {
                    return true;
                }
            }

            return false;
        },

        cleanFiles() {
            for(let img in this.images) {
                this.images[img] = null;
            }

            for(let preview in this.previewImages) {
                this.previewImages[preview] = "";
            }
        },

        async submitImages() {
            if (this.updatedFiles()) {
                this.loadingSaveImgs = true;
                try {
                    const response = await SiteInfoService.updateImages(this.images);
                    if (response) {
                        this.loadingSaveImgs = false;
                        siteInfoStore.updateConstants(response.data.siteInfoData);
                        alertStore.addAlert('success', response.data.message);
                        MetaManager.setAllMeta();
                        this.cleanFiles();
                    }
                } catch (error) {
                    this.loadingSaveImgs = false;
                }
            }
        }
    }
};
</script>

<style scoped>
.previewImg, .preview-ico  {
    display: flex;
    align-items: center;
    justify-content: center;
}

.previewImg img {
    max-width: 150px;
    max-width: 150px;
    object-fit: cover;
}

.preview-ico img {
    max-width: 80px;
    max-height: 80px;
}

.favicon img {
    width: 60px;
    height: 60px;
}

.default-image img {
    width: 150px;
    height: 150px;
}

#workSchedule::placeholder {
    color: #b1b1b1 !important;
    font-size: 14px;
}

.alerta-cache {
    padding: 0.50rem;
    background-color: #cff4fc;
    border-left: 0.25rem solid #9eeaf9;
}
</style>