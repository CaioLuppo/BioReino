import initScrollSuave from './modules/scroll-suave.js';
import initAlterHeader from './modules/alter-header.js';
import initSelectionPlano from './modules/selection-plano.js';
import initDropdownMenu from './modules/dropdown-menu.js';
import ValidateCpf from './modules/validate-cpf.js';
import ValidateCep from './modules/validate-cep.js';
import initClosePopup from './modules/close-popup.js';
import initUserNameLimited from './modules/username-limited.js';

initScrollSuave();
initAlterHeader();
initSelectionPlano();
initDropdownMenu();
initClosePopup();
const cpf = document.querySelector('#cpf');
const cep = document.querySelector('#cep');
if (cpf) new ValidateCpf(cpf).init();
if (cep) new ValidateCep(cep).init();
initUserNameLimited();
