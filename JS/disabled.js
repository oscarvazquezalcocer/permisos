function toggleCamposReposicion() {
    var selectReposicion = document.getElementById("select-reposicion");
    var fechaRep1 = document.getElementById("fechaRep1");
    var fechaRep2 = document.getElementById("fechaRep2");

    if (selectReposicion.value === "Con reposicion") {
      fechaRep1.disabled = false;
      fechaRep2.disabled = false;
    } else {
      fechaRep1.disabled = true;
      fechaRep2.disabled = true;
    }
  }


function toggleCamposMotivo() {
      var selectMotivo = document.getElementById("select-motivo");
      var OtroMotivo = document.getElementById("otroM");
  
      if (selectMotivo.value === "otro") {
        OtroMotivo.disabled = false;
      } else {
        OtroMotivo.disabled = true;
      }
    }