<template>
    <section id="basicInformationView">
        <h5 class="custom_dark mb-3">Informações básicas</h5>

        <form class="container-fluid shadow rounded-2 mb-5 show">
            <div class="row p-3">
                <p class="custom_dark fs-7" >Imagens do site</p>
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
                        
                            <input v-else @change="setImage($event, 'logoImage')" class="form-control custom_focus form-control-sm text-secondary" type="file" :accept="acceptImg">
                            
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
                        
                            <input v-else @change="setImage($event, 'coverImage')" class="form-control custom_focus form-control-sm text-secondary" type="file" :accept="acceptImg">
                            
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
                        
                            <input v-else @change="setImage($event, 'icon')" class="form-control custom_focus form-control-sm text-secondary" type="file" :accept="acceptIcon">
                            
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
                        
                            <input v-else @change="setImage($event, 'defaultImage')" class="form-control custom_focus form-control-sm text-secondary" type="file" :accept="acceptImg">
                            
                        </div>
                    </div>

                    <div v-if="updatedFiles()" class="mb-3 alerta-cache">
                        <p class="m-0" >Pode ser necessário <span class="fw-medium">recarregar a página</span> ou até limpar o cache do navegador para visualizar as alterações nas imagens.</p>
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

        <form class="container-fluid shadow rounded-2 mb-5 show">
            <div class="row shadow rounded-2 p-3">
                <p class="custom_dark fs-7">Informações básicas</p>
                <hr class="custom-hr-dark">

                <div class="mb-3 col-md-4">
                    <label for="webSiteName" class="form-label">Nome do site:</label>
                    <input v-model="basicInfo.webSiteName" type="text" class="form-control form-control-sm custom_focus text-secondary" id="webSiteName">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="email" class="form-label">E-mail:</label>
                    <input v-model="basicInfo.email" type="text" class="form-control form-control-sm custom_focus text-secondary" id="email">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="phone" class="form-label d-flex">Telefone: 
                        <span class="ms-2 w-100 opacity-75 fs-8 d-flex h-100 align-items-center">
                            ( WhatsApp
                            <div class="ms-3 form-check form-switch d-flex align-items-center">
                                <input v-model="basicInfo.phoneIsWhatsApp" class="form-check-input custom_focus cursor_pointer fs-6" type="checkbox" role="switch" id="whatsApp">
                            </div> )
                        </span>
                    </label>
                    <input v-model="basicInfo.phone" type="number" class="form-control form-control-sm custom_focus text-secondary" id="phone">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="workSchedule" class="form-label">Horário:</label>
                    <input v-model="basicInfo.workSchedule" type="text" class="form-control form-control-sm custom_focus text-secondary" id="workSchedule" placeholder="Ex: Segunda a sexta, das 8h00 aś 17h30">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="city" class="form-label">Cidade:</label>
                    <input v-model="basicInfo.city" type="text" class="form-control form-control-sm custom_focus text-secondary" id="city">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="state" class="form-label">Estado:</label>
                    <input v-model="basicInfo.state" type="text" class="form-control form-control-sm custom_focus text-secondary" id="state">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="address" class="form-label">Endereço:</label>
                    <input v-model="basicInfo.address" type="text" class="form-control form-control-sm custom_focus text-secondary" id="address">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="instagram" class="form-label">Instagram:</label>
                    <input v-model="basicInfo.instagram" type="text" class="form-control form-control-sm custom_focus text-secondary" id="instagram">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="facebook" class="form-label">Facebook:</label>
                    <input v-model="basicInfo.facebook" type="text" class="form-control form-control-sm custom_focus text-secondary" id="facebook">
                </div>

                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Descrição: <span class="opacity-75 fs-8">(SEO)</span></label>
                    <textarea v-model="basicInfo.description" name="description" id="description" rows="5" class="form-control custom_focus text-secondary"></textarea>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="keywords" class="form-label">Palavras chaves:<span class="opacity-75 fs-8"> (SEO)</span></label>
                    <textarea name="keywords" v-model="basicInfo.keywords" id="keywords" rows="5" class="form-control custom_focus text-secondary"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button @click="submitBasicInfos()" type="button" class="btn btn-sm btn-primary" :disabled="loadingSaveInfos">
                        <template v-if="!loadingSaveInfos">
                            Salvar Alterações
                        </template>
                        <template v-else>
                            <AppSpinnerLoading message="Aguarde..." color="text-white" />
                        </template>
                    </button>
                </div>
            </div>
        </form>

        <form class="container-fluid shadow rounded-2 mb-5 show">
            <div class="row shadow rounded-2 p-3">
                <p class="custom_dark fs-7">Botão flutuante do WhatsApp</p>
                <hr class="custom-hr-dark">

                <p class="custom_dark fs-7">Ative e integre de forma simples e eficiente o botão flutuante de atendimento pelo WhatsApp em seu site.</p>

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input v-model="widgets.floatingButton.widget_data.active" class="form-check-input custom_focus cursor_pointer" type="checkbox" role="switch" id="activateWhatsApp">
                        <label class="form-label fs-7" for="activateWhatsApp">Ativar botão flutuante</label>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input v-model="widgets.floatingButton.widget_data.useBasicInformationPhone" class="form-check-input custom_focus cursor_pointer" type="checkbox" role="switch" id="useBasicInformationPhone">
                        <label class="form-label fs-7" for="useBasicInformationPhone">Usar telefone das informações básicas</label>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mb-3">
                    <label for="button-position" class="form-label fs-7">Posicionamento do botão</label>
                    <select v-model="widgets.floatingButton.widget_data.position" class="form-select custom_focus form-select-sm text-secondary" id="button-position">
                        <option value="left" :selected="widgets.floatingButton.widget_data.position === 'left'">Esquerda</option>
                        <option value="right" :selected="widgets.floatingButton.widget_data.position === 'right'">Direita</option>
                    </select>
                </div>
                <div v-if="!widgets.floatingButton.widget_data.useBasicInformationPhone" class="col-12 col-sm-4 mb-3">
                    <label for="whatsAppNumber" class="form-label fs-7">Telefone:</label>
                    <input v-model="widgets.floatingButton.widget_data.phone" type="number" class="form-control form-control-sm custom_focus text-secondary" id="whatsAppNumber">
                </div>

                <div class="d-flex justify-content-end">
                    <button @click="submitFLoatingButton()" type="button" class="btn btn-sm btn-primary" :disabled="loadingSaveFloatingButton">
                        <template v-if="!loadingSaveFloatingButton">
                            Salvar Alterações
                        </template>
                        <template v-else>
                            <AppSpinnerLoading message="Aguarde..." color="text-white" />
                        </template>
                    </button>
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
import { widgetStore } from '@/store/widgetStore';
import WidgetService from '@/services/WidgetService';

export default {
    name: 'BasicInformationView',

    components: {
        AppSpinnerLoading
    },

    created() {
        this.getWidgetFloatingButton()
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
            basicInfo: {
                webSiteName: siteInfoStore.constants.webSiteName,
                email: siteInfoStore.constants.email,
                phone: siteInfoStore.constants.phone,
                phoneIsWhatsApp: siteInfoStore.constants.phoneIsWhatsApp === "Y" ? true : false,
                city: siteInfoStore.constants.city,
                state: siteInfoStore.constants.state,
                address: siteInfoStore.constants.address,
                workSchedule: siteInfoStore.constants.workSchedule,
                instagram: siteInfoStore.constants.instagram,
                facebook: siteInfoStore.constants.facebook,
                description: siteInfoStore.constants.description,
                keywords: siteInfoStore.constants.keywords,
            },
            widgets: {
                floatingButton: {
                    id: null,
                    widget_name: "",
                    widget_data: {
                        active: false,
                        phone: "",
                        position: "right",
                        useBasicInformationPhone: false
                    },
                    createdAt: "",
                    updatedAt: ""
                }
            },
            loadingSaveImgs: false,
            loadingSaveInfos: false,
            loadingSaveFloatingButton: false
        }
    },

    beforeCreate() {
        // console.log(siteInfoStore.constants.phoneIsWhatsApp);
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
        },

        async submitBasicInfos() {
            this.loadingSaveInfos = true;

            let data = {...this.basicInfo};
            data.phoneIsWhatsApp = this.basicInfo.phoneIsWhatsApp ? "Y" : "N";

            try {
                const response = await SiteInfoService.updateBasicInfos(data);
                if(response) {
                    this.loadingSaveInfos = false;
                    siteInfoStore.updateConstants(response.data.siteInfoData);
                    alertStore.addAlert('success', response.data.message);
                    MetaManager.setAllMeta();
                }
            } catch (error) {
                this.loadingSaveInfos = false;
            }
        },

        async getWidgetFloatingButton() {
            try {
                const response = await WidgetService.getWidgets();

                if(response.data) {
                    widgetStore.widgets = [];

                    response.data.forEach(widget => {
                        widgetStore.addWidget(widget);
                    });
                }

                widgetStore.widgetsLoaded = true;
                
                const widget = widgetStore.getWidgetByName('floatingButton');
                this.widgets.floatingButton = { ...widget };
            } catch (error) {
                console.error('Erro ao buscar o widget do botão flutuante:', error);
            }
        },

        async submitFLoatingButton() {
            this.loadingSaveFloatingButton = true;

            try {
                const response = await WidgetService.saveWIdget(this.widgets.floatingButton);

                if(response) {
                    this.loadingSaveFloatingButton = false;
                    alertStore.addAlert('success', response.data.message);
                }
            } catch (error) {
                this.loadingSaveFloatingButton = false;
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
    max-height: 150px;
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