// detail.js: Edit / Cancel の表示切替（保存は通常のPOST submit）

(() => {
  const $ = (id) => document.getElementById(id);

  const btnEdit = $("btnEdit");
  const btnCancel = $("btnCancel");
  const btnSave = $("btnSave");
  const editNotice = $("editNotice");

  const viewMode = $("viewMode");
  const editMode = $("editMode");

  if (!btnEdit || !btnCancel || !btnSave || !viewMode || !editMode) return;

  // Snapshot（Cancel用）
  let snapshot = null;

  const show = (el) => el.classList.remove("hidden");
  const hide = (el) => el.classList.add("hidden");

  function toEditMode() {
    snapshot = new FormData(editMode);

    hide(viewMode);
    show(editMode);
    show(btnCancel);
    show(btnSave);
    show(editNotice);
    hide(btnEdit);
  }

  function toViewMode() {
    show(viewMode);
    hide(editMode);
    hide(btnCancel);
    hide(btnSave);
    hide(editNotice);
    show(btnEdit);
  }

  function cancelEdit() {
    if (snapshot) {
      // restore text inputs / textareas
      for (const [k, v] of snapshot.entries()) {
        const el = editMode.elements[k];
        if (!el) continue;

        if (el.type === "checkbox") {
          el.checked = true; // checkedの項目だけ entries に入る
        } else {
          el.value = v;
        }
      }
      // unchecked の復元
      if (editMode.elements["is_resolved"] && !snapshot.has("is_resolved")) {
        editMode.elements["is_resolved"].checked = false;
      }
      if (editMode.elements["is_knowledge"] && !snapshot.has("is_knowledge")) {
        editMode.elements["is_knowledge"].checked = false;
      }
    }
    toViewMode();
  }

  btnEdit.addEventListener("click", toEditMode);
  btnCancel.addEventListener("click", cancelEdit);
})();
