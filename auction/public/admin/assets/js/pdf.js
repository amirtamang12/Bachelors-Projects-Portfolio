window.onload = function (){
    document.getElementById("downloadButton")
    .addEventListener("click", ()=>{
        const booking_details = this.document.getElementById("booking-details");
        console.log(booking_details);
        console.log(window);
        html2pdf().from(booking_details).save();
    })
}