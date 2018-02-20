/* -- A listener to ensure the fonts we need to use have been loaded */

if (document.documentElement.className.indexOf('fonts-loaded') < 0) {
  var panacea = new FontFaceObserver('panacea', {
  })
  var PoppinsLight = new FontFaceObserver('Poppins', {
    weight: 200
  })
  var PoppinsRegular = new FontFaceObserver('Poppins', {
    weight: 400
  })
  var PoppinsMedium = new FontFaceObserver('Poppins', {
    weight: 500
  })
  var PoppinsSemiBold = new FontFaceObserver('Poppins', {
    weight: 600
  })
  var PoppinsBold = new FontFaceObserver('Poppins', {
    weight: 700
  })

  Promise.all([
    panacea.load(''),
    PoppinsLight.load(),
    PoppinsRegular.load(),
    PoppinsMedium.load(),
    PoppinsSemiBold.load(),
    PoppinsBold.load()
  ]).then(function () {
    console.log('Fonts Loaded')
    document.documentElement.className += ' fonts-loaded'
    Cookie.set('fonts-loaded', 1, { expires: '7D', secure: true })
  })
}
