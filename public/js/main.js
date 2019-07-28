const appUsuario = new Vue({
	el: '#appUsuario',
	data: {
		success: '',
		mNombre: '',
		mApellido: '',
		mCorreo: '',
		mContra: '',
		mContraCon: '',
		mGral: '',
		procesando: false
	},
	methods: {
		creaUsuario(e) {
			formData = new FormData(e.target);
			axios.post('registro', formData).then(res => {
				if (res.data.tipo == 1) {
					this.success = res.data.msg
					this.mNombre = ''
					this.mApellido = ''
					this.mCorreo = ''
					this.mContra = ''
					this.mContraCon = ''
					this.procesando = false
					e.target.reset()
					setTimeout(() => {
						this.success = ''
					}, 6000)
				} else if (res.data.tipo == 2) {
					this.mNombre = res.data.msg.errNombre
					this.mApellido = res.data.msg.errApellido
					this.mCorreo = res.data.msg.errCorreo
					this.mContra = res.data.msg.errClave
					this.mContraCon = res.data.msg.errClaveCon
					this.procesando = false
				}
			})
		},
		iniciaSesion(e) {
			formData = new FormData(e.target);
			axios.post('login', formData).then(res => {
				if (res.data.tipo == 1) {
					this.procesando = false
					window.location.replace(res.data.msg);
				} else if (res.data.tipo == 2) {
					this.mCorreo = res.data.msg.errCorreo
					this.mContra = res.data.msg.errClave
					this.mGral = res.data.msg.errGral
					this.procesando = false
				}
			})
		},
		proBtn: function (event) {
			this.procesando = true
		}
	}
})