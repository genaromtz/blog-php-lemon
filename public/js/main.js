const appUsuario = new Vue({
	el: '#appUsuario',
	data: {
		success: '',
		mNombre: '',
		mApellido: '',
		mCorreo: '',
		mPerfil: '',
		mEstado: '',
		mContra: '',
		mContraCon: '',
		mContraAct: '',
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
		editaUsuario(e) {
			formData = new FormData(e.target);
			axios.post('editar', formData).then(res => {
				if (res.data.tipo == 1) {
					this.success = res.data.msg
					this.mNombre = ''
					this.mApellido = ''
					this.mCorreo = ''
					this.mPerfil = ''
					this.mEstado = ''
					this.mGral = ''
					this.procesando = false
					setTimeout(() => {
						this.success = ''
					}, 6000)
				} else if (res.data.tipo == 2) {
					this.mNombre = res.data.msg.errNombre
					this.mApellido = res.data.msg.errApellido
					this.mCorreo = res.data.msg.errCorreo
					this.mPerfil = res.data.msg.errPerfil
					this.mEstado = res.data.msg.errEstado
					this.mGral = res.data.msg.errGral
					this.procesando = false
				}
			})
		},
		actPerfil(e) {
			formData = new FormData(e.target);
			axios.post('perfil', formData).then(res => {
				if (res.data.tipo == 1) {
					this.success = res.data.msg
					this.mNombre = ''
					this.mApellido = ''
					this.mCorreo = ''
					this.mPerfil = ''
					this.mEstado = ''
					this.mGral = ''
					this.mContraAct = ''
					this.mContra = ''
					this.mContraCon = ''
					this.procesando = false
					setTimeout(() => {
						this.success = ''
					}, 6000)
				} else if (res.data.tipo == 2) {
					this.mNombre = res.data.msg.errNombre
					this.mApellido = res.data.msg.errApellido
					this.mCorreo = res.data.msg.errCorreo
					this.mPerfil = res.data.msg.errPerfil
					this.mEstado = res.data.msg.errEstado
					this.mGral = res.data.msg.errGral
					this.mContraAct = res.data.msg.errClaveAct
					this.mContra = res.data.msg.errClave
					this.mContraCon = res.data.msg.errClaveCon
					this.procesando = false
				}
			})
		},
		nuevoUsuario(e) {
			formData = new FormData(e.target);
			axios.post('nuevo', formData).then(res => {
				if (res.data.tipo == 1) {
					this.success = res.data.msg
					this.mNombre = ''
					this.mApellido = ''
					this.mCorreo = ''
					this.mContra = ''
					this.mContraCon = ''
					this.mPerfil = ''
					this.mGral = ''
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
					this.mPerfil = res.data.msg.errPerfil
					this.mGral = res.data.msg.errGral
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

const appPerfil = new Vue({
	el: '#appPerfil',
	data: {
		success: '',
		mNombre: '',
		mEstado: '',
		mModUsu: '',
		mModPer: '',
		mModArt: '',
		mGral: '',
		procesando: false
	},
	methods: {
		creaPerfil(e) {
			formData = new FormData(e.target);
			axios.post('nuevo', formData).then(res => {
				if (res.data.tipo == 1) {
					this.success = res.data.msg
					this.mNombre = ''
					this.mEstado = ''
					this.mModUsu = ''
					this.mModPer = ''
					this.mModArt = ''
					this.mGral = ''
					this.procesando = false
					e.target.reset()
					setTimeout(() => {
						this.success = ''
					}, 6000)
				} else if (res.data.tipo == 2) {
					this.mNombre = res.data.msg.errNombre
					this.mEstado = res.data.msg.errEstado
					this.mModUsu = res.data.msg.errModUsu
					this.mModPer = res.data.msg.errModPer
					this.mModArt = res.data.msg.errModArt
					this.mGral = res.data.msg.errGral
					this.procesando = false
				}
			})
		},
		editaPerfil(e) {
			formData = new FormData(e.target);
			axios.post('editar', formData).then(res => {
				if (res.data.tipo == 1) {
					this.success = res.data.msg
					this.mNombre = ''
					this.mEstado = ''
					this.mModUsu = ''
					this.mModPer = ''
					this.mModArt = ''
					this.mGral = ''
					this.procesando = false
					//e.target.reset() - No necesario al editar
					setTimeout(() => {
						this.success = ''
					}, 6000)
				} else if (res.data.tipo == 2) {
					this.mNombre = res.data.msg.errNombre
					this.mEstado = res.data.msg.errEstado
					this.mModUsu = res.data.msg.errModUsu
					this.mModPer = res.data.msg.errModPer
					this.mModArt = res.data.msg.errModArt
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