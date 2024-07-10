<template>
    <section id="basicInformationView">
        <h5 class="custom_dark mb-3">Informações básicas</h5>

        <form class="container-fluid shadow rounded-2 mb-5">
            <div class="row p-3">
                <p class="custom_dark fs-7" >Informações básicas do site</p>
                <hr class="custom-hr-dark">

                <div class="container mt-3 mb-4">
                <div class="row">
                    <!-- Logo image -->
                    <div class="col-sm-12 col-lg-4 logo-image mb-4">
                        <img :src="previewLogoImg ? previewLogoImg : defaultLogoImage" alt="Logotipo">
                    </div>
                    <div class="col-sm-12 col-lg-8">
                        <p class="custom_dark">Escolha a imagem do seu logotipo</p>
                        <p class="custom_dark opacity-75 fs-7">Recomenda-se dimensão de 250px por 125px, tamanho máximo 5 MB, (JPG, JPEG ou PNG.)</p>

                        <div v-if="previewLogoImg" class="d-flex gap-2 align-items-center">
                            <button @click="cancelSetLogoImg()" type="button" class="btn btn-sm btn-danger">Cancelar</button>
                            <span>{{ logoImage.name }}</span>
                        </div>
                    
                        <input v-else @change="setLogoImage($event)" class="form-control custom_focus form-control-sm" type="file" :accept="acceptImg">
                        
                    </div>
                </div>
            </div>
            </div>
        </form>
    </section>
</template>

<script>
import { siteInfoStore } from '@/store/siteInfoStore';
import defaultLogo from '@/assets/img/default/defaultLogo.png';
import FileValidator from '@/validators/FileValidator';

export default {
    name: 'BasicInformationView',

    data() {
        return {
            acceptImg: "image/jpeg, image/jpg, image/png",
            defaultLogoImage: siteInfoStore.constants.logoImage ? `${this.$API_URL}/uploads/systemImages/${siteInfoStore.constants.logoImage}` : defaultLogo,
            previewLogoImg: "",
            logoImage: null
        }
    },

    methods: {
        setLogoImage(event) {
            const fileInput = event.target;
            const file = fileInput.files?.[0];
            
            if(file) {
                if(FileValidator.validImage(file)) {
                    this.logoImage = file;
                    const reader = new FileReader();

                    reader.onload = () => {
                        this.previewLogoImg = reader.result?.toString();
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileInput.value = '';
                }
            }
        },

        cancelSetLogoImg() {
            this.previewLogoImg = "";
        }
    }
};
</script>

<style scoped>
.logo-image img{
    width: 200px;
    height: 100px;
    object-fit: cover;
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
</style>