function criaMascara(_RefObjeto, _Modelo){

      var valorAtual = _RefObjeto.value;        
      var valorNumerico = '';
      var nIndexModelo = 0;
      var nIndexString = 0;
      var valorFinal = '';
      var adicionarValor = true;


        // limpa a string valor atual para verificar 
        // se todos os caracteres são números
        for (i=0;i<_Modelo.length;i++){
          if (_Modelo.substr(i,1) != '#'){
            valorAtual = valorAtual.replace(_Modelo.substr(i,1),'');
        }}

        // verifica se todos os caracteres são números
        for (i=0;i<valorAtual.length;i++){
          if (!isNaN(parseFloat(valorAtual.substr(i,1)))){
            valorNumerico = valorNumerico + valorAtual.substr(i,1);
        }}

        // aplica a máscara ao campo informado usando
        // o modelo de máscara informado no script
        for (i=0;i<_Modelo.length;i++){

          if (_Modelo.substr(i,1) == '#'){
            if (valorNumerico.substr(nIndexModelo,1) != ''){
              valorFinal = valorFinal + valorNumerico.substr(nIndexModelo,1);
              nIndexModelo++;nIndexString++;
            } 
              else {
                adicionarValor = false;
          }}

            else {
              if (adicionarValor && valorNumerico.substr(nIndexModelo,1) != ''){
              valorFinal = valorFinal + _Modelo.substr(nIndexString,1)
              nIndexString++;
            }}
        }

        //alert(valorFinal)
        _RefObjeto.value = valorFinal 

    }