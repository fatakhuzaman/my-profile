import { initGlobalListeners, initTheme } from './theme';

initGlobalListeners();

/*
 * wire:navigate swaps <body> without a full reload and fires
 * `livewire:navigated` after each visit. initTheme() marks the body it has
 * set up, so calling it from both events never initialises a page twice.
 */
document.addEventListener('DOMContentLoaded', initTheme);
document.addEventListener('livewire:navigated', initTheme);
