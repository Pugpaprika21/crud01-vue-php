// function swlAlert() {
//     Swal.fire({
//         title: "Do you want to save the changes?",
//         showDenyButton: true,
//         showCancelButton: true,
//         confirmButtonText: "Save",
//         denyButtonText: `Don't save`,
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire("Saved!", "", "success");
//         } else if (result.isDenied) {
//             Swal.fire("Changes are not saved", "", "info");
//         }
//     });
// }

/** 
 * @param string dateTime 
 * @returns string
 */
function dateTimeToThai(dateTime) {
    const monthsThai = [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม",
    ];

    const thaiYear = dateTime.getFullYear() + 543;
    const thaiMonth = monthsThai[dateTime.getMonth()];
    const thaiDay = dateTime.getDate();
    const thaiHour = dateTime.getHours();
    const thaiMinute = dateTime.getMinutes();

    return `${thaiDay} ${thaiMonth} ${thaiYear} เวลา ${thaiHour}:${thaiMinute} น.`;
}

/**
 * const url = "https://www.example.com/search?q=javascript&sort=popular";
 * const queryString = getQueryString(url);
 * 
 * @param string url 
 * @returns object
 */
function getQueryString(url) {
    const queryStringIndex = url.indexOf("?");
    if (queryStringIndex === -1) {
        return null;
    }

    const queryString = url.slice(queryStringIndex + 1);
    const queryObject = {};

    queryString.split("&").forEach((keyValuePair) => {
        const [key, value] = keyValuePair.split("=");
        queryObject[key] = decodeURIComponent(value);
    });

    return queryObject;
}