var Script = function () {

    $().ready(function() {
        // validate the comment form when it is submitted
        $("#feedback_form").validate();

        // validate signup form on keyup and submit
        $("#register_form").validate({
            rules: {
                nip: {
                    required: true,
					digits: true
                },
                from: {
                    required: true,
                },
                till: {
                    required: true,
                },
                fare: {
                    required: true,
                },
                name: {
                    required: true,
                },
                user: {
                    required: true,
                    minlength: 5
                },
                address: {
                    required: true
                },
                phone: {
                    required: true,
					digits: true,
                    minlength: 7,
                },
                pass1: {
                    required: true,
                    minlength: 6
                },
                pass2: {
                    required: true,
                    equalTo: "#pass1"
                },
                email: {
                    required: true,
                    email: true
                },
                agree: "required"
            },
            messages: {                
                nip: {
                    required: "Tolong isi ID Pengirim.",
					digits: "Masukan Hanya Angka",
                },                 
                from: {
                    required: "Tolong isi Kota Asal.",
                },                 
                till: {
                    required: "Tolong isi Kota Tujuan.",
                },                 
                fare: {
                    required: "Tolong isi Tarif.",
                },              
                user: {
                    required: "Please provide a username.",
                    minlength: "Username harus lebih dari 5 karakter."
                },                
                name: {
                    required: "Tolong masukan nama.",
                },
                address: {
                    required: "Tolong masukan alamat."
                },
                phone: {
                    required: "Tolong masukan no telp.",
                    minlength: "No Telp harus lebih dari 7 karakter.",
					digits: "Masukan Hanya Angka",
                },
                pass1: {
                    required: "Tolong masukan password.",
                    minlength: "Password harus lebih dari 6 karakter."
                },
                pass2: {
                    required: "Tolong masukan konfirmasi password.",
                    equalTo: "Password tidak sama."
                },
                email: "Tolong masukan email yang benar."
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if(firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });

        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });


}();