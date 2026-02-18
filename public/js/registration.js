document.addEventListener("DOMContentLoaded", function () {
    const customerType = document.getElementById("customer_type");
    const familyIncluded = document.getElementById("family_included");
    const familyCountSection = document.getElementById("familyCountSection");
    const adultsCount = document.getElementById("adults_count");
    const childCount = document.getElementById("child_count");

    function updateFamilyFields() {
        const type = customerType.value;
        const family = familyIncluded.value;

        if (family === "yes" && type === "existing") {
            familyCountSection.style.display = "block";
            adultsCount.required = true;
            childCount.required = true;
        } else if (family === "no" && type === "new") {
            familyCountSection.style.display = "none";
            adultsCount.required = false;
            childCount.required = false;
            adultsCount.value = "";
            childCount.value = "";
        } else if (family === "yes") {
            familyCountSection.style.display = "block";
            adultsCount.required = false;
            childCount.required = false;
        } else {
            familyCountSection.style.display = "none";
            adultsCount.required = false;
            childCount.required = false;
            adultsCount.value = "";
            childCount.value = "";
        }
    }

    if (customerType && familyIncluded) {
        customerType.addEventListener("change", updateFamilyFields);
        familyIncluded.addEventListener("change", updateFamilyFields);
        updateFamilyFields();
    }
});
