
new Vue({
    el: '#clockDiv',
    data: {
       timestamp: "Cargando..................",
       inc: 1
    },
    created() {
        setInterval(this.getNow, 1000);
        setInterval(this.isLogin, 1000 * 60);
    },
    methods: {
        getNow: function() {
            const today     = new Date();
            const dia       = this.pad(today.getDate());
            const mes       = this.pad(today.getMonth()+1);
            const anno      = today.getFullYear();
            const hora      = this.pad(today.getHours());
            const min       = this.pad(today.getMinutes());
            const seg       = this.pad(today.getSeconds());
            const date      = `${dia}/${mes}/${anno}`;
            const time      = `${hora}:${min}:${seg}`;
            const dateTime  = `${date} ${time}`;
            this.timestamp  = dateTime;
        },
        pad: function( n ){
            return n < 10 ? `0${n}` : n;
        },
        isLogin(){
            // console.log(this.inc);

            if ( this.inc > 119 ) {
                window.location.replace(`${base_url}login`);
            }
            this.inc++;
        }
    }
 });