jQuery(document).ready(function ($) {
  $("#shan-fonts-tabs").tabs();

  /* Cache selectors */
  var inputEnable = $("#shan-fonts-is-enabled"),
    inputCSS = $("#shan-fonts-css-generated"),
    inputSelectors = $("#shan-fonts-selectors"),
    inputGoogleFonts = $("#shan-fonts-is-google-fonts"),
    inputGoogleFontName = $("#shan-fonts-google-font-name"),
    inputFonts = $("#shan-fonts-font"),
    inputImportant = $("#shan-fonts-is-important"),
    inputFontWeight = $("#shan-fonts-weight"),
    inputLineheight = $("#shan-fonts-lineheight"),
    inputBodyEnable = $("#shan-fonts-body-is-enabled"),
    inputBodyCSS = $("#shan-fonts-body-css-generated"),
    inputBodySelectors = $("#shan-fonts-body-selectors"),
    inputBodyGoogleFonts = $("#shan-fonts-body-is-google-fonts"),
    inputBodyGoogleFontName = $("#shan-fonts-body-google-font-name"),
    inputBodyFonts = $("#shan-fonts-body-font"),
    inputBodyWeight = $("#shan-fonts-body-weight"),
    inputBodySize = $("#shan-fonts-body-size"),
    inputBodySizeUnit = $("#shan-fonts-body-size-unit"),
    inputBodyLineheight = $("#shan-fonts-body-lineheight"),
    inputBodyImportant = $("#shan-fonts-body-is-important"),
    formshanFonts = $("#shan-fonts-form");

  /* Function to ouput CSS */
  function shan_fonts_generate_css() {
    var css = "";
    var ggfont = inputGoogleFontName.val();
    ggfont = ggfont.replace(/ +(?= )/g, "");

    if (inputSelectors.val() != null && inputSelectors.val() != "")
      css += inputSelectors.val() + " ";

    css += "{\r\n";
    css +=
      '  font-family: "' +
      (inputGoogleFonts.prop("checked") ? ggfont : inputFonts.val()) +
      '", san-serif' +
      (inputImportant.prop("checked") ? " !important" : "") +
      ";\n";
    if (inputFontWeight.val() != null && inputFontWeight.val() != "")
      css +=
        "  font-weight: " +
        inputFontWeight.val() +
        (inputImportant.prop("checked") ? " !important" : "") +
        ";\n";
    if (inputLineheight.val() != null && inputLineheight.val() != "")
      css +=
        "  line-height: " +
        inputLineheight.val() +
        (inputImportant.prop("checked") ? " !important" : "") +
        ";\n";
    css += "}";

    inputCSS.val(css);
  }

  function shan_fonts_body_generate_css() {
    css = "";
    var ggfont = inputBodyGoogleFontName.val();
    ggfont = ggfont.replace(/ +(?= )/g, "");

    if (inputBodySelectors.val() != null && inputBodySelectors.val() != "")
      css += inputBodySelectors.val() + " ";

    css += "{\r\n";
    css +=
      '  font-family: "' +
      (inputBodyGoogleFonts.prop("checked") ? ggfont : inputBodyFonts.val()) +
      '", san-serif' +
      (inputBodyImportant.prop("checked") ? " !important" : "") +
      ";\n";
    if (inputBodySize.val() != null && inputBodySize.val() != "")
      css +=
        "  font-size: " +
        inputBodySize.val() +
        inputBodySizeUnit.val() +
        (inputBodyImportant.prop("checked") ? " !important" : "") +
        ";\n";
    if (inputBodyWeight.val() != null && inputBodyWeight.val() != "")
      css +=
        "  font-weight: " +
        inputBodyWeight.val() +
        (inputBodyImportant.prop("checked") ? " !important" : "") +
        ";\n";
    if (inputBodyLineheight.val() != null && inputBodyLineheight.val() != "")
      css +=
        "  line-height: " +
        inputBodyLineheight.val() +
        (inputBodyImportant.prop("checked") ? " !important" : "") +
        ";\n";
    css += "}";

    inputBodyCSS.val(css);
  }

  /* Conditional Logic */
  function shan_fonts_is_enabled() {
    var is_enabled = inputEnable.prop("checked");

    inputFonts.prop("disabled", !is_enabled);
    inputGoogleFonts.prop("disabled", !is_enabled);
    inputGoogleFontName.prop("disabled", !is_enabled);
    inputFontWeight.prop("disabled", !is_enabled);
    inputLineheight.prop("disabled", !is_enabled);
    inputSelectors.prop("disabled", !is_enabled);
    inputImportant.prop("disabled", !is_enabled);
    inputCSS.toggle(is_enabled);
  }

  function shan_fonts_is_google_fonts() {
    var is_googlefonts = inputGoogleFonts.prop("checked");
    var weight = $("#shan-fonts-weight").val();
    var font = inputFonts.val();
    if (is_googlefonts) {
      $("#shan-fonts-google-font-name").closest("tr").show();
      $("#shan-fonts-font").closest("tr").hide();
      inputFontWeight
        .empty()
        .append($("#shan-fonts-all-weights").children().clone())
        .val(weight);
    } else {
      $("#shan-fonts-google-font-name").closest("tr").hide();
      $("#shan-fonts-font").closest("tr").show();
      inputFontWeight
        .empty()
        .append(
          $("#shan-fonts-" + font + "-weights")
            .children()
            .clone()
        )
        .val(weight);
    }
    if (inputFontWeight.val() == null)
      $("#shan-fonts-weight option:first").attr("selected", "selected");
  }

  function shan_fonts_body_is_enabled() {
    var body_is_enabled = inputBodyEnable.prop("checked");

    inputBodyGoogleFonts.prop("disabled", !body_is_enabled);
    inputBodyGoogleFontName.prop("disabled", !body_is_enabled);
    inputBodyFonts.prop("disabled", !body_is_enabled);
    inputBodyWeight.prop("disabled", !body_is_enabled);
    inputBodySize.prop("disabled", !body_is_enabled);
    inputBodySizeUnit.prop("disabled", !body_is_enabled);
    inputBodyLineheight.prop("disabled", !body_is_enabled);
    inputBodySelectors.prop("disabled", !body_is_enabled);
    inputBodyImportant.prop("disabled", !body_is_enabled);
    inputBodyCSS.toggle(body_is_enabled);
  }

  function shan_fonts_body_is_google_fonts() {
    var body_is_googlefonts = inputBodyGoogleFonts.prop("checked");
    var body_weight = $("#shan-fonts-body-weight").val();
    var body_font = inputBodyFonts.val();
    if (body_is_googlefonts) {
      $("#shan-fonts-body-google-font-name").closest("tr").show();
      $("#shan-fonts-body-font").closest("tr").hide();
      inputBodyFonts
        .empty()
        .append($("#shan-fonts-all-weights").children().clone())
        .val(body_weight);
    } else {
      $("#shan-fonts-body-google-font-name").closest("tr").hide();
      $("#shan-fonts-body-font").closest("tr").show();
      inputBodyWeight
        .empty()
        .append(
          $("#shan-fonts-" + body_font + "-body-weights")
            .children()
            .clone()
        )
        .val(body_weight);
    }
    if (inputFontWeight.val() == null)
      $("shan-fonts-body-weight option:first").arrt("selected", "selected");
  }

  /* Trigger functions when DOM is ready */
  shan_fonts_generate_css();
  shan_fonts_body_generate_css();
  shan_fonts_is_enabled();
  shan_fonts_is_google_fonts();
  shan_fonts_body_is_enabled();
  shan_fonts_body_is_google_fonts();

  /* If using Google Fonts */
  inputGoogleFonts.on("change", function () {
    shan_fonts_is_google_fonts();
    shan_fonts_generate_css();
  });
  inputBodyGoogleFonts.on("change", function () {
    shan_fonts_body_is_google_fonts();
    shan_fonts_body_generate_css();
  });

  /* Output CSS live */
  inputEnable.on("change", function () {
    shan_fonts_is_enabled();
  });
  inputFonts.on("change", function () {
    var font = inputFonts.val();
    var weight = inputFontWeight.val();

    inputFontWeight
      .empty()
      .append(
        $("#shan-fonts-" + font + "-weights")
          .children()
          .clone()
      )
      .val(weight);

    if (inputFontWeight.val() == null)
      $("#shan-fonts-weight option:first").attr("selected", "selected");

    shan_fonts_generate_css();
  });

  inputLineheight.on("keyup focusout", function () {
    shan_fonts_generate_css();
  });

  $("#shan-fonts-weight, #shan-fonts-is-important").on("change", function () {
    shan_fonts_generate_css();
  });

  inputSelectors.on("keyup focusout", function () {
    shan_fonts_generate_css();
  });
  inputGoogleFontName.on("keyup focusout", function () {
    shan_fonts_generate_css();
  });

  inputBodyGoogleFontName.on("keyup focusout", function () {
    shan_fonts_body_generate_css();
  });

  inputBodyEnable.on("change", function () {
    shan_fonts_body_is_enabled();
  });

  inputBodyFonts.on("change", function () {
    shan_fonts_body_generate_css();
  });

  inputBodySize.on("keyup focusout", function () {
    shan_fonts_body_generate_css();
  });

  inputBodySizeUnit.on("change", function () {
    shan_fonts_body_generate_css();
  });

  inputBodyLineheight.on("keyup focusout", function () {
    shan_fonts_body_generate_css();
  });

  $("#shan-fonts-body-weight, #shan-fonts-body-is-important").on(
    "change",
    function () {
      shan_fonts_body_generate_css();
    }
  );

  inputBodySelectors.on("keyup focusout", function () {
    shan_fonts_body_generate_css();
  });

  formshanFonts.on("submit", function (event) {
    formshanFonts.css("opacity", "0.5");
  });
});
