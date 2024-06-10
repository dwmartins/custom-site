<template>
    <footer class="container-fluid bg-body-secondary">
        <div class="container p-3">
            <div class="row">
                <div class="col-4 col-md-4 d-flex justify-content-center align-items-center mb-3 p-0">
                    <ul class="navbar-nav">
                        <li class="nav-item text-secondary"><a class="nav-link">Home</a></li>
                        <li class="nav-item text-secondary"><a class="nav-link">Empresa</a></li>
                        <li class="nav-item text-secondary"><a class="nav-link">Contato</a></li>
                        <li class="nav-item text-secondary"><a class="nav-link">Portfólio</a></li>
                        <li class="nav-item text-secondary"><a class="nav-link">Serviços</a></li>
                    </ul>
                </div>

                <div class="col-8 col-md-4">
                    <div class="d-flex justify-content-center align-items-center h-100 mb-3 p-0">
                        <div class="d-flex flex-column gap-2">
                            <a class="fs-6 link_outline_none text-secondary" href="" target="_blank"><i class="fa-brands fa-whatsapp me-2"></i>phone</a>

                            <a class="fs-6 link_outline_none text-secondary" href="" target="_blank"><i class="fa-regular fa-envelope me-2"></i>email</a>

                            <a class="fs-6 link_outline_none text-secondary" href="" target="_blank"><i class="fa-brands fa-instagram me-2"></i>Instagram</a>

                            <a class="fs-6 link_outline_none text-secondary" href="" target="_blank"><i class="fa-brands fa-square-facebook me-2"></i>Facebook</a> 
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="h-100 d-flex justify-content-center align-items-center">
                        <img class="logo-footer" src="{{ }}" alt="Logo do site">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6 text-secondary text-center fs-7 mb-3">
                    <!-- @if (constants.webSiteName) {
                        {{ constants.webSiteName }} &copy; {{ currentYear }}
                    } -->
                    Dufon Mesas e Cadeiras © 2024
                </div>
                <div class="col-12 col-md-6 text-secondary text-center fs-7">
                    <span> Desenvolvido por: <a class="link_outline_none text-info" href="" target="_blank">dwmcode</a> Desenvolvimento de sites e otimizações</span>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>

export default {
    name: 'AppFooter',
};
</script>

<style>
.logo-footer {
    width: 130px;
}
</style>