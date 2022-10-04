
new Vue({
    el: '#index',
    data: {
        htmlLoading: '<img src="public/images/loading.gif" width="200" class="centerImg">',
        qr: '',
        empresa: {},
        msnMembresia: '',
    },
    created() {
        this.instanciar();
    },
    methods: {
        instanciar() {
            Swal.showLoading();
            const self = this;

            this.$http.post(base_url + 'home/instanciar').then(function(res) {
                
                self.qr             = res.data.qr;
                self.empresa        = res.data.empresa;
                self.msnMembresia   = res.data.msnMembresia;
                Swal.close();

            }, function() {
                console.log('Error instanciar');
            });
        },
        openLoading(){
            this.htmlLoading = '<img src="public/images/loading.gif" width="200" class="centerImg">';
        },
        closeLoading(){
            this.htmlLoading = '';
        }
    }
});