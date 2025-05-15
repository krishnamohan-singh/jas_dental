let cuModal = $("#cuModal");
let form = cuModal.find("form");
const originalAction = form.attr('action');

$(document).on("click", ".cuModalBtn", function () {
    let data = $(this).data();
    let resource = data.resource ?? null;

    form.trigger("reset");
    $('#formMethod').val('POST');
    form.attr('action', originalAction);

    cuModal.find('textarea').text('');
    cuModal.find(".status").empty();

    cuModal.find(".modal-title").text(data.modal_title);

    if (resource) {
        form.attr('action', `/admin/clinic/update/${resource.id}`);
        $('#formMethod').val('PUT');

        let fields = cuModal.find("input, select, textarea");
        fields.each(function (index, element) {
            let fieldName = element.name;

            if (fieldName.substring(fieldName.length - 2) == "[]") {
                fieldName = fieldName.substring(0, fieldName.length - 2);
            }

            if (fieldName != "_token" && fieldName != "_method" && resource[fieldName] !== undefined) {
                if (element.tagName === "TEXTAREA") {
                    $(element).val(resource[fieldName]);
                } else {
                    $(element).val(resource[fieldName]);
                }
            }
        });

        if (data.has_status) {
            cuModal.find(".status").html(`
                <div class="form-group">
                    <label class="fw-bold">Status</label>
                    <input type="checkbox" data-width="100%" data-height="50" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Enabled" data-off="Disabled" name="status">
                </div>
            `);
            cuModal.find("[name=status]").bootstrapToggle(resource.status ? "on" : "off");
        }
    }

    cuModal.modal("show");
});