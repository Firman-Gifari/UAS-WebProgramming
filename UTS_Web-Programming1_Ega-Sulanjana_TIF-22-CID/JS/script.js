async function masuk() {
  const inputEmail = document.getElementById("email-log");
  const inputPassword = document.getElementById("password-log");
  const form = document.getElementsByTagName("form")[0];

  if (form.checkValidity()) {
    event.preventDefault();

    const dataUser = JSON.parse(localStorage.getItem("dataUser"));

    if (
      dataUser.email == inputEmail.value &&
      dataUser.password == inputPassword.value
    ) {
      await Swal.fire(`Selamat datang ${dataUser.uname}`);
      location.href = "../HTML/landingpage.html";
    } else {
      Swal.fire("Maaf, ada inputan yang salah");
    }
  }
}

async function register() {
  const inputEmail = document.getElementById("email");
  const inputPassword = document.getElementById("password");
  const inputUname = document.getElementById("uname");
  const form = document.getElementById("form");
  if (form.checkValidity()) {
    event.preventDefault();
    const dataUser = {
      uname: inputUname.value,
      email: inputEmail.value,
      password: inputPassword.value,
    };

    const dataUserString = JSON.stringify(dataUser);

    localStorage.setItem("dataUser", dataUserString);
    await Swal.fire("Akun telah dibuat");
    location.href = "./login.html";
  }
}
